<div class="relative overflow-x-auto mt-10">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Serial
                </th>
                <th scope="col" class="px-6 py-3">
                    Estado
                </th>
                <th scope="col" class="px-6 py-3">
                    Vendedor
                </th>
                <th scope="col" class="px-6 py-3">
                    Productos
                </th>
                <th scope="col" class="px-6 py-3">
                    Total
                </th>
                <th scope="col" class="px-6 py-3">
                    Fecha
                </th>
                <th scope="col" class="px-6 py-3">
                    
                </th>
            </tr> 
        </thead>

        <tbody>
            @foreach ($this->orders as $order)
                <tr class="bg-white border-b">
                    <td class="py-4 text-ellipsis truncate pl-5">
                        {{ $order->id }}
                    </td>
                    <td class="py-4 text-ellipsis truncate pl-5">
                        {{ $order->serial }}
                    </td>
                    <td class="py-4 text-ellipsis truncate pl-5"> 
                        @if ($order->status == 'pending')
                            <span class="text-orange-500 lowercase bg-orange-100 px-2 py-1 rounded-md border border-orange-500">pendiente</span>
                        @else
                            <span class="text-green-500 lowercase bg-green-100 px-2 py-1 rounded-md border border-green-500">gestionada</span>
                        @endif
                    </td>
                    <td class="py-4 text-ellipsis truncate pl-5">
                        @if($order->wholesaler_id)
                            <span class="flex items-center">
                                {{ $order->wholesaler->name }}
                                <span class="bg-blue-100 text-xs text-blue-800 ml-2 px-2 py-0.5 rounded-full">
                                    Mayorista
                                </span>
                            </span>
                        @else
                            {{ $order->seller ? $order->seller->name : 'Desconocido' }}
                        @endif
                    </td>
                    <td class="py-4 text-ellipsis truncate pl-5">
                        {{ $order->products->sum('amount') }}
                    </td>
                    <td class="py-4 text-ellipsis truncate pl-5">
                        @php
                            $total = 0; 

                            foreach ($order->products as $product) {
                                if($product->product_id) {
                                    $total += $product->amount * $product->product->price;
                                } elseif($product->wholesaler_product_id) {
                                    $total += $product->amount * $product->wholesalerProduct->price;
                                }
                            }
                        @endphp

                        {{ $total }}€
                    </td>
                    <td class="py-4 text-ellipsis truncate pl-5">
                        {{ $order->created_at->format('d/m/Y') }}
                    </td>
                    
                    @livewire('sections.authorized.student.order-items', [
                        "order" => $order
                    ])
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-5">
        {{ $this->orders->links() }}
    </div>
</div>  