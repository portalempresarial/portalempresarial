@extends('web.layouts.sidebar')

@section('body')
<div class="p-6">
    <div class="bg-white shadow-sm rounded-lg">
        <div class="bg-gray-100 p-4 rounded-t-lg border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Albaranes de Mayoristas</h2>
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

            @if($deliveryNotes->isEmpty())
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-md">
                    <div class="flex">
                        <div class="py-1">
                            <span class="material-symbols-outlined mr-2">info</span>
                        </div>
                        <div>
                            <p class="font-bold">No hay albaranes disponibles</p>
                            <p class="text-sm">Los albaranes se generarán automáticamente cuando realice compras a mayoristas.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left">Número</th>
                                <th class="py-3 px-4 text-left">Mayorista</th>
                                <th class="py-3 px-4 text-left">Emisión</th>
                                <th class="py-3 px-4 text-left">Entrega</th>
                                <th class="py-3 px-4 text-left">Estado</th>
                                <th class="py-3 px-4 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($deliveryNotes as $note)
                                <tr>
                                    <td class="py-3 px-4">{{ $note->number }}</td>
                                    <td class="py-3 px-4">{{ $note->wholesaler->name }}</td>
                                    <td class="py-3 px-4">{{ $note->issue_date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4">{{ $note->delivery_date ? $note->delivery_date->format('d/m/Y') : 'No especificada' }}</td>
                                    <td class="py-3 px-4">
                                        @if($note->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Pendiente</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Entregado</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex space-x-2">                                            @php
                                                $company = \App\Models\Company::find(Auth::user()->current_company);
                                                $companySlug = $company ? str_replace(' ', '-', $company->name) : '';
                                            @endphp
                                            <a href="{{ route('delivery-notes.show', ['company' => $companySlug, 'id' => $note->id]) }}" class="text-blue-600 hover:underline flex items-center">
                                                <span class="material-symbols-outlined text-sm mr-1">visibility</span> Ver
                                            </a>
                                            <a href="{{ route('delivery-notes.download', ['company' => $companySlug, 'id' => $note->id]) }}" class="text-green-600 hover:underline flex items-center">
                                                <span class="material-symbols-outlined text-sm mr-1">download</span> Descargar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $deliveryNotes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
