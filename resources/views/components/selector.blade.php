<div class="flex flex-col gap-2 w-full {{ $styles ?? false ? $styles : '' }}">
    @if (isset($label))
        <label class="text-sm text-gray-500">{{ $label }}</label>
    @endif

    <div class="flex flex-row items-center bg-white border border-black transition-all w-full rounded-md px-3">
        <x-icon label="expand_more"/>
    
        <select wire:model.live="{{ $wireModel }}" class="flex-grow w-full py-2.5 bg-transparent text-black focus:outline-none">
            <option value=""></option>

            @foreach ($options as $value)
                <option value="{{ $value['value'] }}" >{{ $value['label'] }}</option>
            @endforeach
        </select>
    </div>
</div>