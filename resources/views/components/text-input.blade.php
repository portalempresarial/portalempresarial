<div class="flex items-center bg-white gap-3 border border-black transition-all w-full flex-1 rounded-md px-3 {{ $styles ?? false ? $styles : '' }}">
    @if ($icon ?? false)
        <span class="material-symbols-outlined {{ $styles ?? '' }}">
            {{$icon}}
        </span>
    @endif

    <input @if ($wireModel ?? false)
        wire:model.live="{{ $wireModel }}"
    @endif value="{{ $value ?? false ? $value : '' }}" @if ($disabled ?? false)
        disabled
    @endif @if ($numeric ?? false)
        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g);"
    @endif type="{{ $type ?? false ? $type : 'text' }}" class="flex-1 py-2 bg-transparent text-black" placeholder="{{ $placeholder ?? false ? $placeholder : '' }}" />
</div>
