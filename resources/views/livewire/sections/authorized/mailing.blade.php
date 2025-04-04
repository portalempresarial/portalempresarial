<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 py-4">
    {{-- Bandeja de entrada --}}
    <div class="bg-gray-100 border border-gray-300 shadow-md p-4 rounded-md overflow-auto">
        <div class="flex flex-col xl:flex-row justify-between">
            <h2 class="text-lg font-semibold mb-4">
                {{ $showDeleted ? '🗑️ Correos Eliminados' : '📩 Bandeja de Entrada' }}
            </h2>
            <div class="flex flex-col sm:flex-row gap-4">
                <x-button 
                    class="material-symbols-outlined" 
                    wireClick="toggleDeleted" 
                    icon=""
                    content="{{ $showDeleted ? 'Recibidos' : 'Eliminados' }}" 
                />
                <x-button 
                    class="material-symbols-outlined" 
                    wireClick="toggleNewEmail" 
                    icon="" 
                    content="Nuevo email" 
                />
            </div>
        </div>

        <ul>
            @forelse($emails as $email)
                @php
                    $mailUser   = $email->recipients->first();
                    $isRead     = $mailUser && $mailUser->pivot->readt_at !== null;
                    $titleClass = $isRead ? 'font-normal' : 'text-blue-500 font-bold';
                    $createdDate = \Carbon\Carbon::parse($email->created_at);
                @endphp

                <li class="relative border-b py-2 hover:bg-gray-200 px-2 cursor-pointer
                    @if(!$isRead) border-l-4 border-blue-500 hover:border-l-8 hover:border-blue-600 @endif
                    @if($isRead) bg-gray-300 @endif"
                    wire:contextmenu.prevent="modalSelectEmail({{ $email->id }})"
                    wire:click.prevent='selectEmail({{ $email->id }})'>
                    
                    <!-- Modal: Se muestra si este email es el seleccionado -->
                    @if($modalSelectedEmail && $modalSelectedEmail->id === $email->id)
                        <div class="absolute -top-20 left-0 right-0 z-50 flex justify-center">
                            <div class="bg-white border border-gray-300 rounded shadow-lg p-4 gap-2 flex flex-col">
                                <span wire:click='closeModal()' class="material-symbols-outlined">close</span>
                                <x-button wireClick="markAsUnread({{ $email->id }})" icon="visibility" content="Marcar como no leido"/>
                                <x-button wireClick="deleteEmail({{ $email->id }})" icon="remove" content="Eliminar correo"/>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-between">
                        <strong class="{{ $titleClass }}">{{ $email->subject }}</strong>
                        <span>
                            @if ($createdDate->isToday())
                                {{ $createdDate->format('H:i') }}
                            @elseif($createdDate->isYesterday())
                                {{ $createdDate->format('d/m H:i') }}
                            @elseif($createdDate->isSameMonth(\Carbon\Carbon::now()))
                                {{ $createdDate->format('d/ H:i') }}
                            @else
                                {{ $createdDate->format('d/m/Y H:i') }}
                            @endif
                        </span>
                    </div>
                    <div class="flex flex-row justify-between mt-2">
                        <span class="text-gray-600 text-sm">{{ Str::limit($email->body, 100) }}</span>
                        @if ($showDeleted)
                            <div class="flex flex-row gap-2" 
                            wire:click='selectEmail({{ $email->id }})'>
                                <x-button 
                                    class="material-symbols-outline" 
                                    wireClick="restoreEmail({{ $email->id }})"
                                    icon="restore" 
                                    content="" 
                                />
                                <x-button 
                                    wireClick="openForceDeleteEmailModal({{ $email->id }})" icon="delete">
                                    Eliminar Correo
                                </x-button>
                            </div>
                        @else
                        <x-button 
                                class="material-symbols-outlined" 
                                wireClick="deleteEmail({{ $email->id }})" 
                                icon="delete"
                                content="" 
                            />
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
    <div>
        {{-- Visualización de un correo seleccionado --}}
        @if($selectedEmail && !$newEmail)
            <div class="bg-gray-100 border border-gray-300 shadow-md p-4 rounded-md mb-4">
                <h3 class="text-xl font-bold">{{ $selectedEmail->subject }}</h3>
                <p class="text-gray-600 mt-2">{{ $selectedEmail->body }}</p>

                {{-- Mostrar Archivos Adjuntos --}}
                @if ($selectedEmail->attachments && $selectedEmail->attachments->isNotEmpty())
                    <div class="mt-4">
                        <h4 class="font-bold mb-2">Archivos Adjuntos:</h4>
                        <ul>
                            @foreach ($selectedEmail->attachments as $attachment)
                                <li>
                                    <a href="{{ Storage::url($attachment->file_path) }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        {{ $attachment->file_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        {{-- Formulario para nuevo email --}}
        @if ($newEmail)
            <div class="bg-gray-100 border border-gray-300 shadow-md p-4 rounded-md">
                <form wire:submit.prevent="submitEmail" enctype="multipart/form-data">
                    <div class="flex flex-col gap-4 mb-4">
                        <div>
                            <x-labeled-input 
                                label="Para:" 
                                wireModel="recipients" 
                                type="text" 
                                icon="" 
                                placeholder="Para" 
                            />
                            <x-error-message field="recipients" />
                        </div>
                        <div>
                            <x-labeled-input
                                label="Asunto:"
                                wireModel="subject"
                                type="text"
                                icon=""
                                placeholder="Título del correo"
                            />
                            <x-error-message field="subject" />
                        </div>

                        <div>
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Mensaje:</label>
                            <textarea id="message" wire:model="body"
                                class="w-full h-64 p-3 border border-gray-300 rounded-md resize-y focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Escribe tu mensaje aquí..."></textarea>
                            <x-error-message field="body" />
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Archivos Adjuntos:</label>
                            <input 
                                type="file" 
                                wire:model="attachments" 
                                multiple
                                class="w-full bg-white p-2 border border-gray-300 rounded-md"
                            />
                            <x-error-message field="attachments.*" />
                        </div>
                    </div>
                    <x-button icon="send">Enviar</x-button>
                </form>
            </div>
        @endif
    </div>

    {{-- Eliminar email modal --}}
     @if($showForceDeleteModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl w-96">
                <h2 class="text-xl font-bold mb-4">Confirmar Eliminación</h2>
                <p>¿Estás seguro de que deseas eliminar este correo de forma permanente? Esta acción no se puede deshacer.</p>
                
                <div class="flex justify-end mt-6 space-x-4">
                    <button 
                        wire:click="$set('showForceDeleteModal', false)" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    
                    <button 
                        wire:click="forceDeleteEmail" 
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

