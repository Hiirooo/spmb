@props([
    'name',
    'label',
    'placeholder' => '',
    'required' => false,
    'hint' => null,
    'span' => 1,
    'rows' => 3,
    'maxlength' => null,
])

@php
    $error = $errors->first($name);
    $colSpan = $span === 2 ? 'sm:col-span-2' : '';
    $hasError = $error !== null;
    $borderCls = $hasError ? 'border-rose-400' : 'border-ink-200 hover:border-ink-300';
@endphp

<div class="flex flex-col gap-1.5 {{ $colSpan }}">
    <label for="field-{{ $name }}" class="text-sm font-semibold text-ink-800">
        {{ $label }}
        @if($required)<span class="ml-0.5 text-gold-600">*</span>@endif
    </label>

    <textarea
        id="field-{{ $name }}"
        wire:model.blur="{{ $name }}"
        placeholder="{{ $placeholder }}"
        rows="{{ $rows }}"
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        class="w-full rounded-lg border bg-white px-3.5 py-2.5 text-[15px] text-ink-900 shadow-soft transition placeholder:text-ink-400 focus:outline-none focus:border-ink-900 focus:shadow-[0_0_0_3px_rgba(184,134,11,0.15)] resize-none leading-relaxed {{ $borderCls }}"
    ></textarea>

    @if($error)
        <p class="text-xs font-medium text-rose-600">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-ink-500">{{ $hint }}</p>
    @endif
</div>
