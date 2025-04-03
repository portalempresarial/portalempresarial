<div class="flex">
    {{-- Bandeja de entrada --}}
    <div class="w-1/3 bg-white shadow-md p-4 rounded-lg">
        <div class="flex flex-row justify-between">
            <h2 class="text-lg font-semibold mb-4">📩 Bandeja de Entrada</h2>
            <x-button
                class="material-symbols-outlined"
                wireClick="toggleNewEmail"
                icon=""
                content="Nuevo email"
            />
        </div>
        
        <ul>
            @forelse($emails as $email)
            @php
                $createdDate = Carbon\Carbon::parse($email->created_at);
            @endphp

            <li 
                class="border-b py-2 hover:bg-gray-100 px-2 cursor-pointer"
                wire:click="selectEmail({{ $email->id }})">
                
                <span class="flex justify-between">
                    <strong>{{ $email->subject }}</strong> 
                    
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
                <span class="text-gray-600 text-sm">{{ Str::limit($email->body, 100) }}</span>
            </li>

            @empty
                <li class="text-gray-500">No tienes correos nuevos.</li>
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
