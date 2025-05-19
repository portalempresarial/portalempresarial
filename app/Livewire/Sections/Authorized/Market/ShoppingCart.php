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
            $imagePath = storage_path('app/public/wholesalers/' . $wholesaler->logo);
            $wholesalerLogoBase64 = '';
            if (file_exists($imagePath)) {
                $image = file_get_contents($imagePath);
                $wholesalerLogoBase64 = base64_encode($image);
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
            
            // Asegurarse de que el directorio existe
            $directory = 'public/delivery_notes';
            if (!\Storage::exists($directory)) {
                \Storage::makeDirectory($directory);
            }
            
            // Guardar el PDF
            $pdfFileName = 'albaran_' . $deliveryNoteNumber . '.pdf';
            $pdfPath = 'delivery_notes/' . $pdfFileName;
            \Storage::put('public/' . $pdfPath, $pdf->output());
            
            // Actualizar el registro del albarán con la ruta al PDF
            $deliveryNote->pdf_path = $pdfPath;
            $deliveryNote->save();
            
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
