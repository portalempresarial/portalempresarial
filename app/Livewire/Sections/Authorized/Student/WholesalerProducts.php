<?php

namespace App\Livewire\Sections\Authorized\Student;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wholesaler;
use App\Models\WholesalerProduct;
use App\Models\Company;
use App\Models\CompanyWholesaler;
use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;

class WholesalerProducts extends Component
{
    use WithPagination;

    public $search = '';
    public $wholesalerFilter = 'all';
    public $wholesalers = [];
    public $company;
    
    protected $listeners = ['cartUpdated' => 'getCartItems'];

    protected $queryString = ['search', 'wholesalerFilter'];    public function mount()
    {
        // 1. Intentar obtener la empresa del usuario actual
        $this->company = Company::find(Auth::user()->current_company);
        
        // 2. Si no hay empresa seleccionada o estamos en la vista de una empresa desde el panel de profesor
        if (!$this->company || Auth::user()->role->name === 'Profesor') {
            $companyParam = request()->route('company');
            
            if ($companyParam) {
                // El parámetro company puede ser un ID o un nombre formateado
                if (is_numeric($companyParam)) {
                    $this->company = Company::find($companyParam);
                } else {
                    // Reemplazamos guiones por espacios para buscar por nombre
                    $companyName = str_replace('-', ' ', $companyParam);
                    
                    // Buscamos primero por nombre exacto
                    $this->company = Company::where('name', $companyName)->first();
                    
                    // Si no encontramos, intentamos con el campo name formateado
                    if (!$this->company) {
                        $this->company = Company::whereRaw('REPLACE(name, " ", "-") = ?', [$companyParam])->first();
                    }
                }
            }
        }
        
        // Cargar los mayoristas asignados a esta empresa
        $this->loadWholesalers();
        
        // Cargar los elementos del carrito
        $this->getCartItems();
    }public function loadWholesalers()
    {
        if ($this->company) {
            $this->wholesalers = $this->company->wholesalers()->get();
        } else {
            $this->wholesalers = collect([]);
        }
    }    public $cartItems = [];
    public $cartItemCount = 0;
    public $miniCartOpen = false;
    
    public function getCartItems()
    {
        // Obtener los elementos del carrito para el usuario actual
        $items = CartProduct::where('user_id', Auth::id())
            ->whereNotNull('wholesaler_product_id')
            ->with('wholesalerProduct')
            ->get();
            
        $this->cartItems = $items;
        $this->cartItemCount = $items->sum('amount');
        
        return $items;
    }
    
    public function removeFromCart($cartItemId)
    {
        CartProduct::where('id', $cartItemId)->delete();
        $this->getCartItems();
    }
      public function incrementCartItem($cartItemId)
    {
        $item = CartProduct::find($cartItemId);
        if ($item && $item->wholesalerProduct) {
            // Verificar si hay suficiente stock
            if ($item->wholesalerProduct->stock > $item->amount) {
                $item->amount += 1;
                $item->save();
                toastr()->success('Cantidad actualizada');
            } else {
                toastr()->error('No hay suficiente stock disponible');
            }
            $this->getCartItems();
        }
    }
    
    public function decrementCartItem($cartItemId)
    {
        $item = CartProduct::find($cartItemId);
        if ($item) {
            if ($item->amount > 1) {
                $item->amount -= 1;
                $item->save();
                toastr()->success('Cantidad actualizada');
            } else {
                $item->delete();
                toastr()->success('Producto eliminado del carrito');
            }
            $this->getCartItems();
        }
    }    public function toggleMiniCart()
    {
        $this->miniCartOpen = !$this->miniCartOpen;
        $this->dispatch('miniCartToggled', $this->miniCartOpen);
    }
    
    protected function getListeners()
    {
        return array_merge($this->listeners, ['toggleMiniCart', 'cartUpdated' => 'getCartItems']);
    }
    
    public function addToCart($productId, $quantity = 1)
    {
        try {
            $product = WholesalerProduct::findOrFail($productId);
            
            // Convertir cantidad a entero para asegurar valores correctos
            $quantity = (int)$quantity;
            if ($quantity < 1) {
                $quantity = 1;
            }
            
            if (!$product || $product->stock < $quantity) {
                toastr()->error('No hay suficiente stock disponible. Stock actual: ' . $product->stock);
                return;
            }
            
            // Verificar si ya existe en el carrito
            $cartItem = CartProduct::where('user_id', Auth::id())
                ->where('wholesaler_product_id', $productId)
                ->first();
                
            if ($cartItem) {
                // Ya existe, actualizar cantidad
                if ($product->stock < ($cartItem->amount + $quantity)) {
                    toastr()->error('No hay suficiente stock disponible. Ya tienes ' . $cartItem->amount . ' en el carrito y solo hay ' . $product->stock . ' disponibles.');
                    return;
                }
                
                $cartItem->amount += $quantity;
                $cartItem->save();
            } else {
                // Crear nuevo ítem en el carrito
                CartProduct::create([
                    'user_id' => Auth::id(),
                    'wholesaler_product_id' => $productId,
                    'amount' => $quantity
                ]);
            }
            
            $this->getCartItems();
            toastr()->success('Producto añadido al carrito');
            
            // Notificar a otros componentes para actualizar el carrito
            $this->dispatch('cartUpdated');
            
        } catch (\Exception $e) {
            toastr()->error('Error al añadir al carrito: ' . $e->getMessage());
        }
    }public function hydrate()
    {
        // Actualizar carrito después de cada actualización del componente
        $this->getCartItems();
    }
    
    public function render()
    {
        // Información de depuración
        $debugInfo = [
            'company_id' => $this->company ? $this->company->id : 'No company',
            'company_name' => $this->company ? $this->company->name : 'No company',
            'wholesaler_count' => $this->wholesalers ? $this->wholesalers->count() : 0,
            'route_name' => request()->route() ? request()->route()->getName() : 'No route',
            'route_params' => request()->route() ? request()->route()->parameters() : []
        ];
        
        // Actualizar conteo de elementos del carrito
        $this->getCartItems();
        // Si no hay una empresa seleccionada o no tiene mayoristas asignados
        if (!$this->company || $this->wholesalers->isEmpty()) {
            return view('livewire.sections.authorized.student.wholesaler-products', [
                'products' => collect([]),
                'debug_info' => $debugInfo
            ]);
        }

        // Obtener los IDs de los mayoristas asignados a esta empresa
        $wholesalerIds = $this->company->wholesalers()->pluck('wholesalers.id')->toArray();
        
        $query = WholesalerProduct::query()
            ->whereIn('wholesaler_id', $wholesalerIds)
            ->where('name', 'like', '%' . $this->search . '%');
            
        if ($this->wholesalerFilter !== 'all') {
            $query->where('wholesaler_id', $this->wholesalerFilter);
        }
        
        $products = $query->paginate(12);
        
        return view('livewire.sections.authorized.student.wholesaler-products', [
            'products' => $products,
            'debug_info' => $debugInfo
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }    public function updatingWholesalerFilter()
    {
        $this->resetPage();
    }
}
