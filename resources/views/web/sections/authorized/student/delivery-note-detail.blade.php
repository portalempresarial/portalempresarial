@extends('web.layouts.sidebar')

@section('body')
<div class="p-6">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="bg-gray-100 p-4 rounded-t-lg border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Albarán #{{ $deliveryNote->number }}</h2>            @php
                $company = \App\Models\Company::find(Auth::user()->current_company);
                $companySlug = $company ? str_replace(' ', '-', $company->name) : '';
            @endphp
            <a href="{{ route('delivery-notes.index', ['company' => $companySlug]) }}" class="flex items-center text-gray-600 hover:text-blue-600">
                <span class="material-symbols-outlined text-sm mr-1">arrow_back</span> 
                Volver
            </a>
        </div>

        <div class="p-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded-md mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Información del Albarán</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="text-gray-600">Número:</div>
                        <div>{{ $deliveryNote->number }}</div>
                        
                        <div class="text-gray-600">Fecha de Emisión:</div>
                        <div>{{ $deliveryNote->issue_date->format('d/m/Y') }}</div>
                        
                        <div class="text-gray-600">Fecha de Entrega:</div>
                        <div>{{ $deliveryNote->delivery_date ? $deliveryNote->delivery_date->format('d/m/Y') : 'No especificada' }}</div>
                        
                        <div class="text-gray-600">Estado:</div>
                        <div>
                            @if($deliveryNote->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Pendiente</span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Entregado</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Partes Involucradas</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="text-gray-600">Mayorista:</div>
                        <div>{{ $deliveryNote->wholesaler->name }}</div>
                        
                        <div class="text-gray-600">Empresa:</div>
                        <div>{{ $deliveryNote->company->name }}</div>
                        
                        <div class="text-gray-600">Número de Pedido:</div>
                        <div>{{ $deliveryNote->order->serial }}</div>
                    </div>
                </div>
            </div>

            <h3 class="text-lg font-medium text-gray-800 mb-3">Productos</h3>
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full bg-white border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left border">Producto</th>
                            <th class="py-3 px-4 text-left border">SKU</th>
                            <th class="py-3 px-4 text-left border">Cantidad</th>
                            <th class="py-3 px-4 text-left border">Precio Unitario</th>
                            <th class="py-3 px-4 text-left border">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @php $total = 0; @endphp
                        @foreach ($deliveryNote->order->products as $product)
                            @if($product->wholesalerProduct)
                                @php $subtotal = $product->amount * $product->wholesalerProduct->price; @endphp
                                @php $total += $subtotal; @endphp
                                <tr>
                                    <td class="py-3 px-4 border">{{ $product->wholesalerProduct->name }}</td>
                                    <td class="py-3 px-4 border">{{ $product->wholesalerProduct->sku ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 border">{{ $product->amount }}</td>
                                    <td class="py-3 px-4 border">{{ number_format($product->wholesalerProduct->price, 2) }} €</td>
                                    <td class="py-3 px-4 border">{{ number_format($subtotal, 2) }} €</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="py-3 px-4 text-right font-medium border">Total</td>
                            <td class="py-3 px-4 font-bold text-blue-600 border">{{ number_format($total, 2) }} €</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="flex justify-center mt-6">
                <a href="{{ route('delivery-notes.download', $deliveryNote->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-md flex items-center transition-colors">
                    <span class="material-symbols-outlined mr-2">download</span>
                    Descargar PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
