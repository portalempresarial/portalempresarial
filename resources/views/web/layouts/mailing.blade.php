@extends('web.layouts.main')

@section('content')
    <main class="flex flex-col lg:flex-row h-screen w-full">
        @isset($company) 
            <x-mailing-sidebar :company="$company" />
        @else
            <x-mailing-sidebar />
        @endisset

        <section class="flex-1 overflow-y-scroll">
            @yield('body')
        </section>
    </main>
@endsection