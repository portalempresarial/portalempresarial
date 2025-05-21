<main x-data="{ page: '{{ $default_page }}' }">
    {{-- @ Navigation --}} 
    <section class="flex items-center gap-2 overflow-x-scroll"> 
        @foreach ($pages as $page)
            <button 
                x-on:click="page = '{{ $page }}'" 
                :class="{ 'bg-blue-500 text-white': page === '{{ $page }}', 'bg-gray-100': page !== '{{ $page }}' }"
                class="transition-all px-5 py-2 rounded-md text-ellipsis truncate min-w-[150px]"
            >{{ $page }}</button>
        @endforeach
    </section>

    {{-- @ Content --}}
    <section 
        x-show="page === 'Comunicados'" 
        x-transition
        class="flex-1 flex-col lg:flex-row mt-10 flex gap-10 justify-between"
    >
        {{-- @ Fixed announcements --}}
        <div class="w-full lg:w-[500px] flex flex-col gap-5">
            <div class="flex items-center gap-2 border-b border-gray-300 pb-2 text-gray-500 text-lg">
                <x-icon label="push_pin" />
                <h2>Comunicados Fijados</h2>
            </div>
            @if ($this->fixed_announcements->isEmpty())
                <div class="flex-1 flex justify-center">
                    <span class="text-gray-500 text-sm">No hay comunicados fijados</span>
                </div>
            @endif
            @foreach ($this->fixed_announcements as $announce)
                <div class="flex gap-2 flex-col bg-{{ $this->getLevelColor($announce->level) }}-100 border border-{{ $this->getLevelColor($announce->level) }}-500 p-5 rounded-md pb-5">
                    @if ($announce->user)
                        <section class="flex items-center gap-3">
                            @if ($announce->user['profile_url'] && file_exists(public_path('storage/profile-pictures/' . $announce->user['profile_url'])))
                                <img class="w-[20px] rounded-full h-[20px]" src="{{ asset('storage/profile-pictures/' . $announce->user['profile_url']) }}" />
                            @else
                                <span class="inline-flex items-center justify-center w-[20px] h-[20px] rounded-full bg-gray-300 text-gray-500">
                                    <span class="material-symbols-outlined text-base">person</span>
                                </span>
                            @endif

                            <span class="text-sm flex-1">
                                {{ $announce->user['name'] }}

                                <small class="text-gray-500">
                                    , {{ $announce->created_at->diffForHumans() }}
                                </small>
                            </span>

                            <span class="material-symbols-outlined text-sm text-{{ $this->getLevelColor($announce->level) }}-500">
                                push_pin
                            </span>
                        </section>
                    @endif

                    <p class="font-bold mt-2 flex gap-3 items-center">  
                        {{ $announce->title }}
                    </p>

                    <small class="text-gray-500 mt-2">
                        {{ $announce->content }}
                    </small> 
                </div>
            @endforeach
        </div>

        <hr class="border-r border-gray-300 h-auto" />

        {{-- @ Last announcements --}}
        <div class="flex-1 flex flex-col gap-5">
            <div class="flex items-center gap-2 border-b border-gray-300 pb-2 text-gray-500 text-lg">
                <x-icon label="notifications" />
                <h2>Últimos Comunicados</h2>
            </div>
            @if ($this->last_announcements->isEmpty())
                <div class="flex-1 flex justify-center">
                    <span class="text-gray-500 text-sm">No hay comunicados recientes</span>
                </div>
            @endif
            @foreach ($this->last_announcements as $announce)
                <div class="flex gap-2 flex-col border-b pb-5">
                    @if ($announce->user)
                        <section class="flex items-center gap-3">
                            @if ($announce->user['profile_url'] && file_exists(public_path('storage/profile-pictures/' . $announce->user['profile_url'])))
                                <img class="w-[20px] rounded-full h-[20px]" src="{{ asset('storage/profile-pictures/' . $announce->user['profile_url']) }}" />
                            @else
                                <span class="inline-flex items-center justify-center w-[20px] h-[20px] rounded-full bg-gray-300 text-gray-500">
                                    <span class="material-symbols-outlined text-base">person</span>
                                </span>
                            @endif

                            <span class="text-sm">
                                {{ $announce->user['name'] }}

                                <small class="text-gray-500">
                                    , {{ $announce->created_at->diffForHumans() }}
                                </small>
                            </span>
                        </section>
                    @endif

                    <p class="font-bold mt-2 flex gap-3 items-center">  
                        {{ $announce->title }}

                        @if($announce['level'] == 0) 
                            <span class="text-gray-500 text-xs uppercase border border-gray-500 bg-gray-100 px-3 py-1 rounded-md">{{ $levels[$announce['level']] }}</span>
                        @elseif($announce['level'] == 1)
                            <span class="text-orange-500 border text-xs uppercase border-orange-500 bg-orange-100 px-3 py-1 rounded-md">{{ $levels[$announce['level']] }}</span>
                        @elseif($announce['level'] == 2)
                            <span class="text-red-500 border text-xs uppercase border-red-500 bg-red-100 px-3 py-1 rounded-md">{{ $levels[$announce['level']] }}</span>
                        @endif
                    </p>

                    <small class="text-gray-500 mt-2">
                        {{ $announce->content }}
                    </small> 
                </div>
            @endforeach

            <div class="mt-5">
                {{ $this->last_announcements->links() }}
            </div>
        </div>
    </section>

    {{-- @ Documentation --}}
    <section 
        x-show="page === 'Documentación'" 
        x-transition
        class="flex-1 mt-10 flex flex-col lg:flex-row flex-wrap justify-between gap-10"
    >
        <section class="select-none flex items-center w-full mb-4">
            @php
                $directories = ["Inicio"];
                foreach (explode('/', $directory) as $dir) {
                    if ($dir) $directories[] = $dir;
                }
            @endphp

            @foreach ($directories as $dir)
                <span class="cursor-pointer text-md" wire:click="setDirectory('{{ $dir }}')">
                    {{ $dir }}
                </span>
                @if (!$loop->last)
                    <span class="material-symbols-outlined">chevron_right</span>
                @endif
            @endforeach
        </section>

        <div class="flex flex-1 gap-10">
            <div class="w-[250px] flex flex-col gap-5 border-r pr-4">
                <div>
                    <div class="font-bold text-blue-500 mb-2">Carpetas</div>
                    @forelse ($folders as $folder)
                        <div wire:click="addDirectory('{{ basename($folder) }}')" class="flex gap-3 items-center text-md cursor-pointer hover:bg-blue-50 rounded px-2 py-1">
                            <span class="material-symbols-outlined text-md">folder</span>
                            {{ basename($folder) }}
                        </div>
                    @empty
                        <div class="text-gray-400 text-sm">No hay carpetas</div>
                    @endforelse
                </div>
                <div>
                    <div class="font-bold text-blue-500 mb-2 mt-4">Archivos</div>
                    @forelse ($files as $file)
                        <div wire:click="openFile('{{ basename($file) }}')" class="flex gap-3 items-center text-md cursor-pointer hover:bg-blue-50 rounded px-2 py-1">
                            <span class="material-symbols-outlined text-md">description</span>
                            {{ basename($file) }}
                        </div>
                    @empty
                        <div class="text-gray-400 text-sm">No hay archivos</div>
                    @endforelse
                </div>
            </div>

            <div class="flex-1 flex flex-col gap-5">
                @if ($fileView)
                    <textarea wire:model.live="fileContent" class="block flex-1 w-full bg-gray-50 rounded-md border border-gray-200 shadow-sm p-5 resize-none" readonly></textarea>
                    <div class="flex gap-2 mt-2">
                        <button wire:click="closeFile" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition-all">Cerrar archivo</button>
                    </div>
                @else
                    <div class="h-full bg-gray-50 flex-1 w-full rounded-md border border-gray-200 flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined">description</span>
                        <span class="text-gray-400">Selecciona un archivo para visualizarlo</span>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <style>
        *::-webkit-scrollbar {
            display: none;
        }   
        
        * {
            scrollbar-width: none;
        }    
    </style>
</main>