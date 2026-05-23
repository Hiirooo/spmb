@props([
    'name',
    'label',
    'required' => false,
    'hint' => null,
    'span' => 1,
])

@php
    $error = $errors->first($name);
    $colSpan = $span === 2 ? 'sm:col-span-2' : '';
@endphp

<div class="flex flex-col gap-1.5 {{ $colSpan }}">
    <label for="field-{{ $name }}" class="text-sm font-semibold text-ink-800">
        {{ $label }}
        @if($required)
            <span class="ml-0.5 text-gold-600">*</span>
        @endif
    </label>

    {{ $slot }}

    @if($error)
        <p class="text-xs font-medium text-rose-600">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-ink-500">{{ $hint }}</p>
    @endif
</div>
