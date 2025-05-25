<x-modal wire:model="managing" styles="flex flex-col gap-3">
    <h2 class="text-lg flex items-center gap-3">
        @if ($current_order && $current_order->seller && $current_order->seller->icon && file_exists(public_path('storage/companies/' . $current_order->seller->icon)))
            <img class="max-w-[30px] rounded-md h-[15px]"
                src="{{ asset('storage/companies/' . $current_order->seller->icon) }}" />
        @else
            <span class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-full bg-gray-300 text-gray-500">
                <span class="material-symbols-outlined text-base">business</span>
            </span>
        @endif

        {{ $current_order && $current_order->seller ? $current_order->seller->name : '' }}
    </h2>

    <div class="my-3">
        <span
            class="text-green-500 bg-green-100 text-xs px-2 py-1 rounded-md border border-green-500 uppercase">{{ $current_order ? $current_order->serial : '' }}</span>
    </div>

    <table class="w-full text-sm text-left text-gray-500 my-3">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Producto
                </th>
                <th scope="col" class="px-6 py-3">
                    Cantidad
                </th>
                <th scope="col" class="px-6 py-3">
                    Precio
                </th>
            </tr>
        </thead>

        @if ($current_order && count($current_order->products) > 0)
            <tbody>
                @foreach ($current_order->products as $product)
                    <tr class="bg-white border-b">
                        <td class="py-4 text-ellipsis truncate pl-5">
                            @if($product->product)
                                {{ Str::limit($product->product->label, 30, '...') }}
                            @else
                                <span class="text-red-500">Producto eliminado</span>
                            @endif
                        </td>
                        <td class="py-4 text-ellipsis truncate pl-5">
                            {{ $product->amount }}
                        </td>
                        <td class="py-4 text-ellipsis truncate pl-5">
                            @if($product->product)
                                {{ $product->product->price * $product->amount }}€
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>

    @if ($current_order && $current_order->status == 'pending')
        <x-button wireClick="confirm" styles="justify-center" content="Confirmar compra" />
    @endif
</x-modal>