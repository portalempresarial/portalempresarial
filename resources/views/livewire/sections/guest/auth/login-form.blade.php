<div>
    @error('credentials')
        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
    @enderror

    @error('email')
        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
    @enderror

    <div class="flex flex-col gap-3">   
        <x-text-input wireModel="email" type="email" icon="alternate_email" placeholder="Dirección de correo" />

        @error('password')
            <span class="text-red-500 text-sm mt-2" {{ $message }}</span>
        @enderror

        <x-text-input wireModel="password" type="password" icon="lock" placeholder="Contraseña" />
    </div>

    <button wire:click="confirm"
        class="mt-5 bg-blue-500 hover:bg-blue-700 transition-all text-white w-full py-2 rounded-md">
        Iniciar sesión
    </button>
</div>