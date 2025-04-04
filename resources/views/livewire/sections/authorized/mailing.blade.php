<div class="flex">
    {{-- Bandeja de entrada --}}
    <div class="w-1/3 bg-white shadow-md p-4 rounded-lg">
        <div class="flex flex-row justify-between">
            <h2 class="text-lg font-semibold mb-4">
                {{ $showDeleted ? '🗑️ Correos Eliminados' : '📩 Bandeja de Entrada' }}
            </h2>
            <div class="flex flex-row">
                <x-button class="material-symbols-outlined" wireClick="toggleDeleted" icon="" content="{{ $showDeleted ? 'Recibidos' : 'Eliminados' }}" />
                <x-button class="material-symbols-outlined" wireClick="toggleNewEmail" icon="" content="Nuevo email" />
            </div>
        </div>
        
        <ul>
            @forelse($emails as $email)
                @php
                    $mailUser = $email->recipients->first();
                    $isRead = $mailUser && $mailUser->pivot->readt_at !== null;
                    
                    $liClass = "border-b py-2 hover:bg-gray-200 px-2 cursor-pointer";
                    $titleClass = $isRead ? "font-normal" : "text-blue-500 font-bold";
                    
                    if (!$isRead) {
                        $liClass .= " border-l-4 border-blue-500 hover:border-l-8 hover:border-blue-600";
                    } else {
                        $liClass .= " bg-gray-300";
                    }
                @endphp
                
                <li class="{{ $liClass }}" wire:click="selectEmail({{ $email->id }})">
                    @php
                        $createdDate = Carbon\Carbon::parse($email->created_at);
                    @endphp
                    <span class="flex justify-between">
                        <strong class="{{ $titleClass }}">{{ $email->subject }}</strong>
                        @if ($createdDate->isToday())
                            <span>{{ $createdDate->format('H:i') }}</span>
                        @elseif($createdDate->isYesterday())
                            <span>{{ $createdDate->format('d/m H:i') }}</span>
                        @elseif($createdDate->isSameMonth(Carbon\Carbon::now()))
                            <span>{{ $createdDate->format('d/ H:i') }}</span>
                        @else
                            <span>{{ $createdDate->format('d/m/Y H:i') }}</span>
                        @endif
                    </span>
                    <br>
                    <div class="flex flex-row justify-between">
                        <span class="text-gray-600 text-sm">{{ Str::limit($email->body, 100) }}</span>
                        @if ($showDeleted)
                            <x-button class="material-symbols-outline" wireClick="restoreEmail({{ $email->id }})" icon="restore" content="" />
                            <x-button class="material-symbols-outline" wireClick="forceDeleteEmail({{ $email->id }})" icon="delete" content="" />
                        @else
                            <x-button class="material-symbols-outlined" wireClick="deleteEmail({{ $email->id }})" icon="delete" content="" />
                        @endif
                    </div>
                </li>
            @empty
                <li class="text-gray-500">
                    {{ $showDeleted ? 'No tienes correos eliminados.' : 'No tienes correos nuevos.' }}
                </li>
            @endforelse
        </ul>

        <div class="mt-4">
            {{ $emails->links() }}
        </div>
    </div>

    {{-- Panel derecho --}}
    <div class="w-2/3 pl-4">
        {{-- Visualización de un correo seleccionado --}}
        @if($selectedEmail && !$newEmail)
            <div class="bg-white shadow-md p-6 rounded-lg mb-4">
                <h3 class="text-xl font-bold">{{ $selectedEmail->subject }}</h3>
                <p class="text-gray-600 mt-2">{{ $selectedEmail->body }}</p>
            </div>
        @endif
        
        {{-- Formulario para nuevo email --}}
        @if ($newEmail)
            <div class="bg-white shadow-md p-6 rounded-lg">
                <form wire:submit.prevent="submitEmail">
                    <div class="mb-4">
                        <x-labeled-input 
                            label="Para"
                            wireModel="recipients"
                            type="text"
                            icon=""
                            placeholder="Para"
                        />
                        <label class="block mb-2 text-sm font-medium text-gray-700">Asunto:</label>
                        <input 
                            type="text" 
                            wire:model="subject" 
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Título del correo"
                        >
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Mensaje:</label>
                        <textarea 
                            id="message" 
                            wire:model="body" 
                            class="w-full h-64 p-3 border border-gray-300 rounded-lg resize-y focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Escribe tu mensaje aquí..."
                        ></textarea>
                    </div>
                    
                    <x-button 
                        icon="send"
                    >
                        Enviar
                    </x-button>
                </form>
            </div>
        @endif
    </div>
</div>