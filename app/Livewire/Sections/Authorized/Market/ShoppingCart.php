<?php

namespace App\Livewire\Sections\Authorized\Market;
use Livewire\Component;
use App\Models\CartProduct; 
use App\Models\Product;
use App\Models\WholesalerProduct;
use App\Models\Company; 
use App\Models\Wholesaler;
use App\Models\Order; 
use App\Models\OrderProduct;
use App\Models\DeliveryNote;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Attributes\Url;

class ShoppingCart extends Component {
    public $items = [], $companies = []; 

    public function deleteElement($id) {
        CartProduct::where('id', $id)->delete();
    }

    public function addOne($id) {
        $product = CartProduct::where('id', $id)->first();
        
        // Si es un producto normal
        if ($product->product_id) {
            $product->amount += 1;
            $product->save();
        } 
        // Si es un producto de mayorista, verificar stock
        elseif ($product->wholesaler_product_id) {
            $wholesalerProduct = $product->wholesalerProduct;
            if ($wholesalerProduct && $wholesalerProduct->stock > $product->amount) {
                $product->amount += 1;
                $product->save();
            } else {
                toastr()->error('No hay suficiente stock disponible');
            }
        }
    }

    public function removeOne($id) {
        $product = CartProduct::where('id', $id)->first();

        if(($product->amount - 1) == 0) {
            $product->delete();
            return;
        }

        $product->amount -= 1;
        $product->save();
    }

    public function checkout() {
        try {
            // Procesar productos de empresas
            foreach ($this->companies as $key => $value) {
                $order = Order::create([
                    'serial' => 'ORD' . $value->id . auth()->user()->id . time(),
                    'user_id' => auth()->user()->id,
                    'buyer_company_id' => auth()->user()->current_company,
                    'seller_company_id' => $value->id
                ]);

                foreach ($this->items as $item) {
                    // Solo procesamos productos normales asignados a esta empresa
                    if ($item->product_id && $item->product->company_id == $value->id) {
                        // Verificar stock disponible
                        $product = Product::find($item->product_id);
                        if (!$product || $product->stock < $item->amount) {
                            throw new \Exception("No hay suficiente stock para el producto {$product->label}");
                        }
                        
                        // Crear el registro de orden
                        OrderProduct::create([
                            'order_id' => $order->id,
                            'product_id' => $item->product_id,
                            'amount' => $item->amount
                        ]);
                        
                        // Actualizar el stock
                        $product->stock -= $item->amount;
                        $product->save();
                        
                        // También actualizamos el registro en company_product_stock si existe
                        $stockRecord = \App\Models\CompanyProductStock::where('company_id', $product->company_id)
                            ->where('product_id', $product->id)
                            ->first();
                            
                        if ($stockRecord) {
                            $stockRecord->stock -= $item->amount;
                            $stockRecord->save();
                        }

                        CartProduct::where('id', $item->id)->delete();
                    }
                }

                toastr()->success("Orden procesada con éxito: " . $order->serial);
            }
            
            // Procesar productos de mayoristas
            foreach ($this->wholesalers as $key => $wholesaler) {
                $order = Order::create([
                    'serial' => 'WSLORD' . $wholesaler->id . auth()->user()->id . time(),
                    'user_id' => auth()->user()->id,
                    'buyer_company_id' => auth()->user()->current_company,
                    'seller_company_id' => null, // No hay empresa vendedora, es un mayorista
                    'wholesaler_id' => $wholesaler->id // Agregamos el ID del mayorista
                ]);

                foreach ($this->items as $item) {
                    // Solo procesamos productos de mayoristas asignados a este mayorista
                    if ($item->wholesaler_product_id && $item->wholesalerProduct->wholesaler_id == $wholesaler->id) {
                        OrderProduct::create([
                            'order_id' => $order->id,
                            'wholesaler_product_id' => $item->wholesaler_product_id,
                            'amount' => $item->amount
                        ]);

                        // Actualizar stock del producto
                        $product = WholesalerProduct::find($item->wholesaler_product_id);
                        if ($product && $product->stock >= $item->amount) {
                            $product->stock -= $item->amount;
                            $product->save();
                            
                            // Crear entrega pendiente (llegará al día siguiente)
                            $deliveryDate = now()->addDay();
                            \App\Models\PendingWholesalerDelivery::create([
                                'order_id' => $order->id,
                                'company_id' => auth()->user()->current_company,
                                'delivery_date' => $deliveryDate,
                                'processed' => false
                            ]);
                            
                            // Generar albarán
                            $this->generateDeliveryNote($order, $wholesaler, $deliveryDate);
                        }

                        CartProduct::where('id', $item->id)->delete();
                    }
                }

                toastr()->success("Orden de mayorista procesada con éxito: " . $order->serial);
            }
        } catch (\Throwable $th) {
            \Log::error($th);
            toastr()->error("Ocurrió un error al procesar la orden");
        }
    }
    
    public $wholesalers = [];

    /**
     * Genera un albarán para una compra a mayorista
     * 
     * @param Order $order La orden de compra
     * @param Wholesaler $wholesaler El mayorista proveedor
     * @param Carbon $deliveryDate Fecha de entrega programada
     * @return void
     */
    private function generateDeliveryNote($order, $wholesaler, $deliveryDate) {
        try {
            // Crear el registro del albarán en la base de datos
            $deliveryNoteNumber = DeliveryNote::generateNumber($wholesaler->id, $order->id);
            $buyerCompany = Company::find(auth()->user()->current_company);
            
            $deliveryNote = \App\Models\DeliveryNote::create([
                'number' => $deliveryNoteNumber,
                'order_id' => $order->id,
                'company_id' => auth()->user()->current_company,
                'wholesaler_id' => $wholesaler->id,
                'issue_date' => now(),
                'delivery_date' => $deliveryDate,
                'status' => 'pending',
                'notes' => 'Pedido realizado a través del Portal Empresarial'
            ]);
            
            // Calcular el total
            $total = 0;
            $orderProducts = OrderProduct::where('order_id', $order->id)->get();
            foreach ($orderProducts as $orderProduct) {
                $total += $orderProduct->amount * $orderProduct->wholesalerProduct->price;
            }
            
            // Obtener la imagen del mayorista para el PDF
            $wholesalerLogoBase64 = '';
            try {
                // Primero, asegurémonos de que el directorio existe
                $wholesalersDir = storage_path('app/public/wholesalers');
                if (!file_exists($wholesalersDir)) {
                    \Log::info("Creando directorio para logos de mayoristas: $wholesalersDir");
                    if (!mkdir($wholesalersDir, 0755, true)) {
                        \Log::error("No se pudo crear el directorio para logos de mayoristas: $wholesalersDir");
                    }
                }
                
                // Intentar cargar el logo si existe
                if ($wholesaler->logo && !empty($wholesaler->logo)) {
                    $imagePath = storage_path('app/public/wholesalers/' . $wholesaler->logo);
                    if (file_exists($imagePath)) {
                        $image = file_get_contents($imagePath);
                        $wholesalerLogoBase64 = base64_encode($image);
                        \Log::info("Logo del mayorista cargado correctamente: " . $wholesaler->logo);
                    } else {
                        \Log::warning("Logo del mayorista no encontrado: $imagePath - Continuando sin logo");
                    }
                } else {
                    \Log::warning("Mayorista no tiene logo especificado - Continuando sin logo");
                }
            } catch (\Exception $e) {
                \Log::error("Error al cargar logo del mayorista: " . $e->getMessage());
                // Continuamos sin el logo, no detenemos el proceso
            }
            
            // Generar el PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.delivery_note', [
                'delivery_note' => $deliveryNote,
                'order' => $order,
                'products' => $orderProducts,
                'wholesaler' => $wholesaler,
                'company' => $buyerCompany,
                'total' => $total,
                'icon' => $wholesalerLogoBase64
            ])->setPaper('A4');
            
            // Asegurarse de que el directorio existe en ambos lugares
            $storageDirectory = 'public/delivery_notes';
            $physicalDirectory = storage_path('app/public/delivery_notes');
            
            if (!\Storage::exists($storageDirectory)) {
                \Storage::makeDirectory($storageDirectory);
                \Log::info("Directorio de almacenamiento creado: $storageDirectory");
            } else {
                \Log::info("Directorio de almacenamiento ya existe: $storageDirectory");
            }
            
            if (!file_exists($physicalDirectory)) {
                if (mkdir($physicalDirectory, 0755, true)) {
                    \Log::info("Directorio físico creado: $physicalDirectory");
                } else {
                    \Log::error("No se pudo crear el directorio físico: $physicalDirectory");
                }
            } else {
                \Log::info("Directorio físico ya existe: $physicalDirectory");
            }
            
            // Guardar el PDF
            $pdfFileName = 'albaran_' . $deliveryNoteNumber . '.pdf';
            $pdfPath = 'delivery_notes/' . $pdfFileName;
            $fullPath = 'public/' . $pdfPath;
            $absolutePath = storage_path('app/' . $fullPath);
            
            try {
                // Guardar el PDF de forma forzada usando dos métodos para asegurar que funcione
                $content = $pdf->output();
                
                // Método 1: Usando Storage Facade
                $bytes = \Storage::put($fullPath, $content);
                \Log::info("PDF guardado con Storage::put en: $fullPath, bytes escritos: $bytes");
                
                // Método 2: Usando file_put_contents directamente (como backup)
                $bytesWritten = file_put_contents($absolutePath, $content);
                \Log::info("PDF guardado con file_put_contents en: $absolutePath, bytes escritos: $bytesWritten");
                
                $fileExists = false;
                
                // Verificar que se haya guardado correctamente
                if (\Storage::exists($fullPath)) {
                    $fileExists = true;
                    \Log::info("Verificado con Storage: el archivo existe, tamaño: " . \Storage::size($fullPath) . " bytes");
                } else {
                    \Log::warning("Verificación con Storage falló, comprobando con file_exists...");
                    if (file_exists($absolutePath)) {
                        $fileExists = true;
                        \Log::info("Verificado con file_exists: el archivo existe, tamaño: " . filesize($absolutePath) . " bytes");
                    } else {
                        \Log::error("Error: el archivo no existe después de guardarlo ni con Storage ni con file_put_contents");
                    }
                }
                
                if ($fileExists) {
                    // Actualizar el registro del albarán con la ruta al PDF
                    $deliveryNote->pdf_path = $pdfPath;
                    $deliveryNote->save();
                    \Log::info("Ruta de PDF actualizada en registro de albarán: $pdfPath");
                } else {
                    \Log::error("No se pudo guardar el PDF, no se actualiza la ruta en la base de datos");
                }
                
            } catch (\Exception $e) {
                \Log::error("Error al guardar el PDF: " . $e->getMessage());
                \Log::error("Traza: " . $e->getTraceAsString());
                // No lanzamos la excepción para evitar que se rompa el flujo
                // Al menos el albarán queda registrado en la base de datos
            }
            
            // No tratamos de descargar el PDF automáticamente desde un componente Livewire
            // En su lugar, mostrar un mensaje de éxito con enlace
            toastr()->success("Albarán generado correctamente. Puede descargarlo desde la sección de albaranes.");
        } catch (\Throwable $th) {
            \Log::error($th);
            toastr()->error("Ocurrió un error al generar el albarán");
        }
    }
    
    public function render() {
        // Obtener todos los productos en el carrito
        $this->items = CartProduct::where('user_id', auth()->user()->id)->get();
    
        // Procesar productos normales
        $productIds = CartProduct::where('user_id', auth()->user()->id)
            ->whereNotNull('product_id')
            ->select('product_id')
            ->pluck('product_id')
            ->toArray(); 
        
        $this->companies = Company::whereIn('id', 
            Product::whereIn('id', $productIds)
                ->select('company_id')
                ->pluck('company_id')
                ->toArray()
        )->get();
        
        // Procesar productos de mayoristas
        $wholesalerProductIds = CartProduct::where('user_id', auth()->user()->id)
            ->whereNotNull('wholesaler_product_id')
            ->select('wholesaler_product_id')
            ->pluck('wholesaler_product_id')
            ->toArray();
            
        $this->wholesalers = Wholesaler::whereIn('id', 
            WholesalerProduct::whereIn('id', $wholesalerProductIds)
                ->select('wholesaler_id')
                ->pluck('wholesaler_id')
                ->toArray()
        )->get();
        
        return view('livewire.sections.authorized.market.shopping-cart');
    }
}
