@extends('web.layouts.sidebar')

@section('body')
    <main class="w-full p-10">
        <section class="flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <h2 class="text-2xl font-extrabold text-blue-500">
                    Compras a Empresas
                </h2>
                <small>Previsualiza todas las compras realizadas a otras empresas</small>
            </div>
            <div>
                @if(request()->is('teacher*'))
                    <a href="{{ url('teacher/companies/'.request()->route('company').'/view/delivery-notes') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                        <span class="material-symbols-outlined mr-1">receipt_long</span>
                        Ver albaranes de mayoristas
                    </a>
                @else
                    <a href="{{ url('student/'.request()->route('company').'/delivery-notes') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                        <span class="material-symbols-outlined mr-1">receipt_long</span>
                        Ver albaranes de mayoristas
                    </a>
                @endif
            </div>
        </section>

        @livewire('sections.authorized.student.sells.buy')
    </main>
@endsection