<?php

namespace App\Livewire\Sections\Authorized\Student;

use Livewire\Component;
use App\Models\WholesalerProduct;
use App\Models\CartProduct;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class AddToWholesalerCart extends Component
{
    public $wholesalerProductId;
    public $quantity = 1;
    public $maxStock = 0;
    
    public function mount($wholesalerProductId)
    {
        $this->wholesalerProductId = $wholesalerProductId;
        $product = WholesalerProduct::find($wholesalerProductId);
        if ($product) {
            $this->maxStock = $product->stock;
        }
    }
    
    public function incrementQuantity()
    {
        if ($this->quantity < $this->maxStock) {
            $this->quantity++;
        }
    }
    
    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
    
    public function addToCart()
    {
        $product = WholesalerProduct::find($this->wholesalerProductId);
        
        if (!$product || $product->stock < $this->quantity) {
            toastr()->error('No hay suficiente stock disponible');
            return;
        }
        
        // Verificar si ya existe en el carrito
        $cartItem = CartProduct::where('user_id', Auth::id())
            ->where('wholesaler_product_id', $this->wholesalerProductId)
            ->first();
            
        if ($cartItem) {
            // Ya existe, actualizar cantidad
            if ($product->stock < ($cartItem->amount + $this->quantity)) {
                toastr()->error('No hay suficiente stock disponible. Ya tienes ' . $cartItem->amount . ' en el carrito.');
                return;
            }
            
            $cartItem->amount += $this->quantity;
            $cartItem->save();
        } else {
            // Crear nuevo ítem en el carrito
            CartProduct::create([
                'user_id' => Auth::id(),
                'wholesaler_product_id' => $this->wholesalerProductId,
                'amount' => $this->quantity
            ]);
        }
        
        $this->quantity = 1;
        $this->dispatch('cartUpdated');
        toastr()->success('Producto añadido al carrito');
    }
    
    public function render()
    {
        return view('livewire.sections.authorized.student.add-to-wholesaler-cart');
    }
}
