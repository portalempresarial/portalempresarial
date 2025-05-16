<div class="flex flex-col" wire:key="cart-component-{{ $wholesalerProductId }}">
    <div class="flex items-center gap-2 mb-2">
        <button 
            wire:click.prevent="decrementQuantity"
            type="button"
            class="w-8 h-8 bg-gray-200 text-gray-700 flex items-center justify-center rounded-md hover:bg-gray-300"
        >
            <span class="material-symbols-outlined text-sm">remove</span>
        </button>
        
        <input 
            type="number" 
            wire:model.live="quantity" 
            min="1" 
            max="{{ $maxStock }}"
            class="w-12 text-center border rounded-md p-1 text-sm"
        >
        
        <button 
            wire:click.prevent="incrementQuantity"
            type="button"
            class="w-8 h-8 bg-gray-200 text-gray-700 flex items-center justify-center rounded-md hover:bg-gray-300"
        >
            <span class="material-symbols-outlined text-sm">add</span>
        </button>
    </div>
    
    <button 
        wire:click.prevent="addToCart"
        type="button"
        class="bg-blue-500 text-white px-4 py-2 rounded-md flex items-center gap-2 hover:bg-blue-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
        {{ $maxStock <= 0 ? 'disabled' : '' }}
    >
        <span class="material-symbols-outlined">add_shopping_cart</span>
        Añadir al carrito
    </button>
</div>
