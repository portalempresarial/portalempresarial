<main class="w-full p-10 flex h-screen flex-col overflow-y-scroll">
    @php
        use App\Models\Company; 
    @endphp

    <section class="flex gap-3 items-end flex-wrap">
        <x-labeled-input 
            styles="flex-1"
            label="Dirección de la página" 
            type="text"
            wireModel="website"
            icon="public"
        />

        <input type="file" wire:model="iconImage" accept="image/*" class="block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        @error('iconImage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        @if ($company && $company->icon)
            <img src="{{ asset('storage/companies/' . $company->icon) }}" class="w-12 h-12 rounded-full mt-2 border" />
        @endif
        @if (session('icon_success'))
            <span class="text-green-600 text-xs">{{ session('icon_success') }}</span>
        @endif

        <button wire:click="save" class="mt-5 bg-blue-500 hover:bg-blue-700 transition-all text-white py-2 px-5 rounded-md">
            Guardar
        </button>
    </section>

    

    @error('website')
        <p class="text-red-500 text-sm my-2">
            {{ $message }}
        </p>
    @enderror

    @if ($company && $company->website)
        <iframe src="{{ $company->website }}" class="w-full flex-1 mt-7 border"></iframe>
    @else
        <div class="flex-1 bg-gray-100 border flex items-center mt-7 justify-center">
            <h1 class="text-gray-500">
                No has configurado tu página web
            </h1>
        </div>
    @endif
</main>