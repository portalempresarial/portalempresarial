{{-- filepath: resources/views/livewire/sections/authorized/student/wholesaler-products.blade.php --}}
<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div class="w-full md:w-1/3">
            <div class="flex items-center gap-2 bg-white border border-gray-300 rounded-md px-3 py-2">
                <span class="material-symbols-outlined text-gray-500">search</span>
                <input wire:model.live="search" type="text" placeholder="Buscar productos..."
                    class="flex-1 outline-none bg-transparent">
            </div>
        </div>

        @if(count($this->wholesalers) > 0)
            <div class="w-full md:w-1/3">
                <select wire:model.live="wholesalerFilter"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none">
                    <option value="all">Todos los mayoristas</option>
                    @foreach($this->wholesalers as $wholesaler)
                        <option value="{{ $wholesaler->id }}">{{ $wholesaler->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="w-full md:w-1/3 relative">
            <a href="/market/cart"
                class="flex items-center gap-2 justify-center w-full bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 transition-all">
                <span class="material-symbols-outlined">shopping_cart</span>
                Ver carrito
                <span id="cartCount"
                    class="bg-white text-blue-500 rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold">
                    {{ $this->cartItemCount }}
                </span>
            </a>
        </div>
    </div>

    @if(!$this->company)
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
        </div>
    @endif

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
                            <img src="{{ asset('storage/wholesaler-products/' . $product->image) }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover">
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
                        <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $product->description }}</p>
                        <div class="flex flex-col mt-4">
                            <div class="flex items-center gap-2 mb-2">
                                <button wire:click="decrementQuantity({{ $product->id }})" type="button"
                                    class="w-8 h-8 bg-gray-200 text-gray-700 flex items-center justify-center rounded-md hover:bg-gray-300">
                                    <span class="material-symbols-outlined text-sm">remove</span>
                                </button>
                                <input type="number" wire:model="quantities.{{ $product->id }}" min="1" max="{{ $product->stock }}"
                                    class="w-12 text-center border rounded-md p-1 text-sm"
                                    @if($product->stock <= 0) disabled @endif>
                                <button wire:click="incrementQuantity({{ $product->id }}, {{ $product->stock }})" type="button"
                                    class="w-8 h-8 bg-gray-200 text-gray-700 flex items-center justify-center rounded-md hover:bg-gray-300">
                                    <span class="material-symbols-outlined text-sm">add</span>
                                </button>
                            </div>
                            <button wire:click="addToCart({{ $product->id }})" type="button"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md flex items-center gap-2 hover:bg-blue-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                                @if($product->stock <= 0) disabled @endif>
                                <span class="material-symbols-outlined">add_shopping_cart</span>
                                Añadir al carrito
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</div>