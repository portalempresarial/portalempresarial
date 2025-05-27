@extends('web.layouts.sidebar')

@section('body')
    <main class="w-full p-10">
        <section class="flex flex-col gap-1 mb-3">
            <h2 class="text-2xl font-extrabold text-blue-500">
                Ajustes de la empresa
            </h2>

            <small>Configura los ajustes de tu empresa, incluyendo información de contacto, logo y más.</small>
        </section>
        @livewire('sections.authorized.student.sells.website')
    </main>
@endsection