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
use Livewire\Attributes\Url;

class ShoppingCart extends Component {
    public $items = [], $companies = []; 

    public function deleteElement($id) {
        CartProduct::where('id', $id)->delete();
    }

    public function addOne($id) {
        $product = CartProduct::where('id', $id)->first();
        $product->amount += 1;
        $product->save();
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
