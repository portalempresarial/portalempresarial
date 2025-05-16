<div>    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div class="w-full md:w-1/3">
            <div class="flex items-center gap-2 bg-white border border-gray-300 rounded-md px-3 py-2">
                <span class="material-symbols-outlined text-gray-500">search</span>
                <input 
                    wire:model.live="search" 
                    type="text" 
                    placeholder="Buscar productos..." 
                    class="flex-1 outline-none bg-transparent"
                >
            </div>
        </div>

        @if(count($this->wholesalers) > 0)
        <div class="w-full md:w-1/3">
            <select 
                wire:model.live="wholesalerFilter" 
                class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none"
            >
                <option value="all">Todos los mayoristas</option>
                @foreach($this->wholesalers as $wholesaler)
                    <option value="{{ $wholesaler->id }}">{{ $wholesaler->name }}</option>
                @endforeach
            </select>
        </div>
        @endif        <div class="w-full md:w-1/3 relative">
            <button 
                wire:click.prevent="toggleMiniCart"
                type="button"
                class="flex items-center gap-2 justify-center w-full bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition-all"
            >
                <span class="material-symbols-outlined">shopping_cart</span>
                Ver carrito
                <span id="cartCount" class="bg-white text-blue-500 rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold">
                    {{ $this->cartItemCount }}
                </span>
            </button>
        </div>
    </div>@if(!$this->company)
        <div class="mt-10 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md">
            <div class="flex">
                <div class="py-1">
                    <span class="material-symbols-outlined mr-2">error</span>
                </div>
                <div>
                    <p class="font-bold">No se pudo encontrar la empresa</p>
                    <p class="text-sm">Ha ocurrido un error al obtener la información de la empresa.</p>
                </div>
            </div>
        </div>
    @elseif(count($this->wholesalers) === 0)
        <div class="mt-10 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-md">
            <div class="flex">
                <div class="py-1">
                    <span class="material-symbols-outlined mr-2">warning</span>
                </div>
                <div>
                    <p class="font-bold">No hay mayoristas asignados a esta empresa</p>
                    <p class="text-sm">
                        @if(auth()->user()->role->name === 'Profesor')
                            Para asignar mayoristas a esta empresa, vaya a la sección "Detalles" y luego a "Mayoristas".
                        @else
                            Por favor, contacte con su profesor para asignar mayoristas a su empresa.
                        @endif
                    </p>
                </div>
            </div>
        </div>    @endif
    @if($products->isEmpty())
        <div class="mt-10 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-md">
            <div class="flex">
                <div class="py-1">
                    <span class="material-symbols-outlined mr-2">info</span>
                </div>
                <div>
                    <p class="font-bold">No se encontraron productos</p>
                    <p class="text-sm">Intente con otros términos de búsqueda o seleccione otro mayorista.</p>
                </div>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition-all hover:shadow-lg">
                    <div class="bg-gray-100 h-48 flex items-center justify-center">
                        @if($product->image)
                            <img 
                                src="{{ asset('storage/wholesaler-products/' . $product->image) }}" 
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <span class="material-symbols-outlined text-gray-400 text-6xl">inventory_2</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ \App\Models\Wholesaler::find($product->wholesaler_id)->name }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-blue-600">{{ $product->price }}€</p>
                                @if($product->stock > 0)
                                    <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                        En stock: {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="text-xs text-red-600 bg-red-100 px-2 py-1 rounded-full">
                                        Agotado
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $product->description }}</p>                  <div class="mt-4" wire:key="container-cart-{{ $product->id }}">
                            @livewire('sections.authorized.student.add-to-wholesaler-cart', ['wholesalerProductId' => $product->id], key('cart-'.$product->id))
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
          <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
    <!-- Mini Cart -->
    <div id="miniCart" class="fixed top-20 right-5 w-80 bg-white shadow-lg rounded-lg p-4 z-50 transform transition-transform duration-300 ease-in-out overflow-hidden {{ $miniCartOpen ? '' : 'translate-x-full' }}">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg">Mi Carrito</h3>
            <button wire:click.prevent="toggleMiniCart" type="button" class="text-gray-500 hover:text-gray-700">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
          <div class="max-h-96 overflow-y-auto">
            @if(count($cartItems) > 0)
                @foreach($cartItems as $item)
                    <div class="flex flex-col py-2 border-b">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1">
                                <h4 class="font-medium text-sm">{{ $item->wholesalerProduct->name }}</h4>
                                <p class="text-gray-500 text-xs">{{ $item->amount }} x {{ $item->wholesalerProduct->price }}€</p>
                            </div>
                            <button wire:click.prevent="removeFromCart({{ $item->id }})" class="text-red-400 hover:text-red-600 ml-2">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </div>
                        <div class="flex items-center justify-end gap-2">
                            <button wire:click.prevent="decrementCartItem({{ $item->id }})" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-300">
                                <span class="material-symbols-outlined text-sm">remove</span>
                            </button>
                            <span class="text-sm font-medium w-6 text-center">{{ $item->amount }}</span>
                            <button wire:click.prevent="incrementCartItem({{ $item->id }})" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-300">
                                <span class="material-symbols-outlined text-sm">add</span>
                            </button>
                        </div>
                    </div>
                @endforeach
                
                <div class="mt-4 flex justify-between font-semibold">
                    <span>Total:</span>
                    <span>{{ $cartItems->sum(function($item) { return $item->amount * $item->wholesalerProduct->price; }) }}€</span>
                </div>
                
                <div class="mt-4">
                    <a href="/market/cart" class="block w-full bg-blue-500 text-white text-center py-2 rounded-md hover:bg-blue-600 transition-all">
                        Ir al carrito
                    </a>
                </div>
            @else                <p class="text-gray-500 text-center py-4">Tu carrito está vacío</p>
                <div class="mt-4">
                    <button wire:click.prevent="toggleMiniCart" type="button" class="block w-full bg-gray-200 text-gray-800 text-center py-2 rounded-md hover:bg-gray-300 transition-all">
                        Continuar comprando
                    </button>
                </div>
            @endif
        </div>
    </div>    <script>
        // Escuchar eventos de Livewire para manejar animaciones adicionales o efectos visuales
        document.addEventListener('livewire:initialized', () => {
            // Suscribirse a eventos para posibles animaciones adicionales
            @this.on('miniCartToggled', (isOpen) => {
                // Aquí podríamos añadir animaciones adicionales si fuera necesario
                const miniCart = document.getElementById('miniCart');
                if (miniCart) {
                    if (isOpen) {
                        // Podría ser útil para añadir más animaciones o efectos visuales
                        console.log('Mini carrito abierto');
                    } else {
                        // Podría ser útil para añadir más animaciones o efectos visuales
                        console.log('Mini carrito cerrado');
                    }
                }
            });
            
            // Suscribirse a eventos de actualización de carrito si necesitamos efectos adicionales
            @this.on('cartUpdated', () => {
                // Por ejemplo, podríamos añadir una animación de rebote al contador del carrito
                const cartCount = document.getElementById('cartCount');
                if (cartCount) {
                    cartCount.classList.add('animate-bounce');
                    setTimeout(() => {
                        cartCount.classList.remove('animate-bounce');
                    }, 1000);
                }
            });
        });
    </script>
</div>
