@extends('web.layouts.main')

@section('content')
    <main 
        class="flex flex-col items-center justify-center h-screen w-screen bg-no-repeat bg-center bg-cover"
        style="background-image: url({{ URL::to('/') }}/assets/squares-wallpaper.png)"
    >
        <section class="w-[90%] md:w-[400px] flex flex-col gap-3 bg-white rounded-md">
            <h1 class="text-4xl font-extrabold">Iniciar sesión</h1>
            <p class="text-gray-400 mb-5">Por favor, introduzca sus credenciales para iniciar sesión en la plataforma.</p>
        
            @livewire('sections.guest.auth.login-form')

            <small onclick="window.location.href = '{{ route('recover') }}'" class="w-full cursor-pointer text-end text-gray-500 transition-all">¿Has olvidado tu contraseña?</small>
        </section>
    </main>
@endsection