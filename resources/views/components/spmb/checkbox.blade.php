@props([
    'name',
    'label',
    'hint' => null,
])

@php
    $error = $errors->first($name);
@endphp

<div class="flex flex-col gap-1">
    <label class="flex cursor-pointer items-center gap-2.5 text-sm text-ink-800">
        <input type="checkbox" wire:model.live="{{ $name }}" class="h-[18px] w-[18px]" />
        <span>{{ $label }}</span>
    </label>

    @if($error)
        <p class="ml-7 text-xs font-medium text-rose-600">{{ $error }}</p>
    @elseif($hint)
        <p class="ml-7 text-xs text-ink-500">{{ $hint }}</p>
    @endif
</div>
