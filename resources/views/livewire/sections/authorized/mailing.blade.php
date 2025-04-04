<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 py-4">
    {{-- Bandeja de entrada --}}
    <div class="bg-gray-100 border border-gray-300 shadow-md p-4 rounded-md overflow-auto">
        <div class="flex flex-col xl:flex-row justify-between">
            <h2 class="text-lg font-semibold mb-4">
                {{ $showDeleted ? '🗑️ Correos Eliminados' : '📩 Bandeja de Entrada' }}
            </h2>
            <div class="flex flex-col sm:flex-row gap-4">
                <x-button class="material-symbols-outlined" wireClick="toggleDeleted" icon=""
                    content="{{ $showDeleted ? 'Recibidos' : 'Eliminados' }}" />
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
                                    <div class="flex flex-row gap-2">
                                        <x-button class="material-symbols-outline" wireClick="restoreEmail({{ $email->id }})"
                                            icon="restore" content="" />
                                        <x-button class="material-symbols-outline" wireClick="forceDeleteEmail({{ $email->id }})"
                                            icon="delete" content="" />
                                    </div>
                                @else
                                    <x-button class="material-symbols-outlined" wireClick="deleteEmail({{ $email->id }})" icon="delete"
                                        content="" />
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
                @if ($selectedEmail->attachments && $selectedEmail->attachments->count() > 0)
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
                        <x-labeled-input label="Para:" wireModel="recipients" type="text" icon="" placeholder="Para" />
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Asunto:</label>
                            <input type="text" wire:model="subject"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Título del correo">
                        </div>
                        <div>
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Mensaje:</label>
                            <textarea id="message" wire:model="body"
                                class="w-full h-64 p-3 border border-gray-300 rounded-md resize-y focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Escribe tu mensaje aquí..."></textarea>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Archivos Adjuntos:</label>
                            <input type="file" wire:model="attachments" multiple
                                class="w-full bg-white p-2 border border-gray-300 rounded-md">
                            @error('attachments.*') <span class="error text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <x-button icon="send">Enviar</x-button>
                </form>
            </div>
        @endif
    </div>
</div>