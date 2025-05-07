<section class="flex-1 p-4 flex flex-wrap flex-col gap-7">
    <div class="w-full flex flex-wrap items-center gap-4 justify-between">
        <div class="flex-1 italic text-sm">
            Encontrados {{ count($products) }} resultados...
        </div>

        <x-text-input wireModel="product_filter" type="text" icon="search"
            styles="text-sm w-[150px] border-gray-400 text-gray-400" placeholder="Buscador de productos" />

        <?php 
            $stringOptions = [
                "Agricultura",
                "Animales",
                "Arte y cultura",
                "Belleza y estética",
                "Bodas",
                "Coches",
                "Alimentación",
                "Construcción",
                "Deportes",
                "Educación",
                "Hostelería",
                "Imagen y sonido",
                "Informática",
                "Jardinería",
                "Joyerías",
                "Material y mobiliario de oficina",
                "Moda",
                "Muebles",
                "Ocio",
                "Pequeños comercios",
                "Restaurantes",
                "Salud y parafarmacia",
                "Seguridad",
                "Servicios a empresas",
                "Telecomunicaciones",
                "Transportes, logística y almacenamiento",
                "Viajes"
            ];

            foreach ($stringOptions as $option) {
                $options[] = [
                    "value" => $option,
                    "label" => $option
                ];
            }

            $companyOptions = [];

            foreach ($companiesList as $company) {
                $companyOptions[] = [
                    "value" => $company->id,
                    "label" => $company->name
                ];
            }
        ?>

        <x-selector wireModel="sector" styles="text-sm w-full md:w-[250px] border-gray-400 text-gray-400"
            :options="$options" />

        <x-selector wireModel="company" styles="text-sm w-full md:w-[250px] border-gray-400 text-gray-400"
            :options="$companyOptions" />
    </div>

    <div class="flex-1 flex flex-col gap-10">
        @foreach ($companiesList as $company)
            <div class="p-5 border border-gray-300 rounded-md shadow-md bg-white lg:mx-24">
                <div class="flex items-center gap-5">
                    @if ($company->icon)
            <div class="p-5 border border-gray-300 rounded-md shadow-md bg-white mx-24">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-5">
                        @if ($company->icon)
                        <img class="max-w-[70px] rounded-md-sm h-[50px]"
                            src="{{ asset('storage/companies/' . $company->icon) }}" />
                        @endif
                        <h2>
                            <a href="/market/company/{{ str_replace(' ', '-', $company->name) }}"
                                class="text-xl text-blue-500 font-bold hover:text-blue-700 transition-all">
                                {{ $company->name }}
                            </a>
        
                            @if ($company->sector)
                                <span class="text-xs text-gray-400 block">
                                    {{ $company->sector }}
                                </span>
                            @endif
                        </h2>
                    </div>
                    <div class="flex items-center">
                        <a href="/market/company/{{ str_replace(' ', '-', $company->name) }}"
                            class="text-sm text-blue-500 font-bold hover:text-blue-700 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined">public</span> <!-- Ícono de Material Icons -->
                            Visita la página de la empresa
                        </a>
                    </div>
                </div>
    
                @php
                    $companyProducts = $products->where('company_id', $company->id);
                    $visibleProducts = $companyProducts->take(8);
                    $hiddenProducts = $companyProducts->skip(8); 
                @endphp
    
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
                    <!-- Mostrar los primeros 8 productos -->
                    @foreach ($visibleProducts as $product)
                        <div onclick="window.location.href = '/market/company/{{ str_replace(' ', '-', $product->company->name) }}?product={{ str_replace(' ', '-', $product->label) }}'" class="bg-gray-100 border border-gray-300 flex flex-col gap-4 rounded-md shadow-md p-4 cursor-pointer group transition-all hover:scale-105 hover:bg-blue-500 hover:text-white">
                            <div class="flex justify-between w-full">
                                <div class="flex flex-col">
                                    <!-- Nombre del producto -->
                                    <h3 class="text-lg font-semibold">{{ $product->label }}</h3>
    
                                    <!-- Descripción del producto con límite de caracteres -->
                                    @if ($product->description && strlen($product->description) > 0)
                                        <p class="text-sm text-gray-400 group-hover:text-blue-200 transition-all">
                                            {{ Str::limit($product->description, 100) }}
                                        </p>
                                    @endif
                                </div>
                                <div>
                                    <!-- Imagen del producto -->
                                    @if ($product->image)
                                        <img class="max-w-[70px] rounded-md-sm h-[50px]"
                                            src="{{ asset('storage/products/' . $product->image) }}" />
                                    @endif
                                </div>
                            </div>
                            <div class="mt-auto flex justify-end">
                                <span class="text-lg font-bold text-blue-500 group-hover:text-white transition-all">
                                    {{ $product->price }} €
                                </span>
                            </div>                            
                        </div>
                    @endforeach
    
                    <!-- Productos adicionales ocultos inicialmente -->
                    <div x-data="{ showMore: false }" class="col-span-full">
                        <div x-show="showMore" x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-400"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 overflow-hidden">
                            @foreach ($hiddenProducts as $product)
                                <div onclick="window.location.href = '/market/company/{{ str_replace(' ', '-', $product->company->name) }}?product={{ str_replace(' ', '-', $product->label) }}'"
                                    class="bg-gray-100 border border-gray-300 flex flex-col gap-4 rounded-md shadow-md p-4 cursor-pointer group transition-all hover:scale-105 hover:bg-blue-500 hover:text-white">
                                    <div class="flex justify-between w-full">
                                        <div class="flex flex-col">
                                            <!-- Nombre del producto -->
                                            <h3 class="text-lg font-semibold">{{ $product->label }}</h3>

                                            <!-- Descripción del producto con límite de caracteres -->
                                            @if ($product->description && strlen($product->description) > 0)
                                                <p class="text-sm text-gray-400 group-hover:text-blue-200 transition-all">
                                                    {{ Str::limit($product->description, 100) }}
                                                </p>
                                            @endif
                                        </div>
                                        <div>
                                            <!-- Imagen del producto -->
                                            @if ($product->image)
                                                <img class="max-w-[70px] rounded-md-sm h-[50px]"
                                                    src="{{ asset('storage/products/' . $product->image) }}" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-auto flex justify-end">
                                        <span class="text-lg font-bold text-blue-500 group-hover:text-white transition-all">
                                            {{ $product->price }} €
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Botón "Ver más" -->
                        @if ($hiddenProducts->count() > 0)
                        <div class="flex justify-center text-center">
                            <button @click="showMore = !showMore"
                                class="mt-4 p-2 shadow-md rounded-md bg-blue-500 text-white hover:bg-blue-700 hover:scale-105 font-semibold transition-all flex items-center justify-center gap-2">
                                <span x-show="!showMore">Ver más productos</span>
                                <span x-show="showMore">Ver menos productos</span>
                                <span :class="{'rotate-180': showMore}" class="transition-transform duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach
        
        <div class="mt-5">
            {{ $companiesList->links() }}
        </div>
    </div>
</section>