<div class="flex h-screen flex-col overflow-y-scroll">
    @php
        use App\Models\Company; 
    @endphp

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-gray-50 border border-gray-200 shadow-md rounded-md p-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona tu mayorista</label>
            <select wire:model="selectedWholesaler" class="w-full border rounded-md p-2">
                <option value="">-- Selecciona un mayorista --</option>
                @foreach($wholesalers as $wholesaler)
                    <option value="{{ $wholesaler->id }}">
                        {{ $wholesaler->name }} ({{ $wholesaler->sector ? $wholesaler->sector->sector_name : 'Sin sector' }})
                    </option>
                @endforeach
            </select>
            <button wire:click="assignWholesaler"
                class="mt-2 bg-blue-500 hover:bg-blue-700 transition-all text-white py-2 px-5 rounded-md">
                Asignar mayorista
            </button>
        </div>
        <div class="flex flex-col gap-4 bg-gray-50 border border-gray-200 shadow-md rounded-md p-4">
            <h2 class="text-sm text-gray-500">Icono de la empresa</h2>
            <div class="flex flex-row items-center gap-4 flex-wrap">
                <input type="file" wire:model="iconImage" accept="image/*"
                    class="block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                @error('iconImage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                @if ($company && $company->icon)
                    <img src="{{ asset('storage/companies/' . $company->icon) }}"
                        class="w-12 h-12 rounded-full mt-2 border" />
                @endif
                @if (session('icon_success'))
                    <span class="text-green-600 text-sm">{{ session('icon_success') }}</span>
                @endif
            </div>

            <button wire:click="save"
                class="mt-5 bg-blue-500 hover:bg-blue-700 transition-all text-white py-2 px-5 rounded-md">
                Guardar
            </button>
        </div>
        <div class="bg-gray-50 border border-gray-200 shadow-md rounded-md p-4">
            <x-labeled-input styles="flex-1" label="Dirección de la página" type="text" wireModel="website"
                icon="public" />
        </div>
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
</div>