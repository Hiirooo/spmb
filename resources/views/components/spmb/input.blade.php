@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'hint' => null,
    'span' => 1,
    'autocomplete' => null,
    'autofocus' => false,
    'inputmode' => null,
    'maxlength' => null,
    'minlength' => null,
    'mono' => false,
    'modifiers' => 'blur',
])

@php
    $error = $errors->first($name);
    $colSpan = $span === 2 ? 'sm:col-span-2' : '';
    $hasError = $error !== null;
    $monoCls = $mono ? 'font-mono tracking-wide' : '';
    $borderCls = $hasError ? 'border-rose-400' : 'border-ink-200 hover:border-ink-300';
    $modifier = $modifiers ? '.'.$modifiers : '';
@endphp

<div class="flex flex-col gap-1.5 {{ $colSpan }}">
    <label for="field-{{ $name }}" class="text-sm font-semibold text-ink-800">
        {{ $label }}
        @if($required)<span class="ml-0.5 text-gold-600">*</span>@endif
    </label>

    @if($type === 'password')
        <div x-data="{ show: false }" class="relative">
            <input
                :type="show ? 'text' : 'password'"
                id="field-{{ $name }}"
                wire:model{{ $modifier }}="{{ $name }}"
                placeholder="{{ $placeholder }}"
                @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                @if($autofocus) autofocus @endif
                @if($maxlength) maxlength="{{ $maxlength }}" @endif
                class="w-full rounded-lg border bg-white px-3.5 py-2.5 pr-11 text-[15px] text-ink-900 shadow-soft transition placeholder:text-ink-400 focus:outline-none focus:border-ink-900 focus:shadow-[0_0_0_3px_rgba(184,134,11,0.15)] {{ $monoCls }} {{ $borderCls }}"
            />
            <button type="button" @click="show = !show" tabindex="-1"
                class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex h-7 w-7 items-center justify-center rounded-md text-ink-400 hover:bg-paper hover:text-ink-700">
                <svg x-show="!show" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <svg x-show="show" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
            </button>
        </div>
    @else
        <input
            type="{{ $type }}"
            id="field-{{ $name }}"
            wire:model{{ $modifier }}="{{ $name }}"
            placeholder="{{ $placeholder }}"
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if($autofocus) autofocus @endif
            @if($inputmode) inputmode="{{ $inputmode }}" @endif
            @if($maxlength) maxlength="{{ $maxlength }}" @endif
            @if($minlength) minlength="{{ $minlength }}" @endif
            {{ $attributes }}
            class="w-full rounded-lg border bg-white px-3.5 py-2.5 text-[15px] text-ink-900 shadow-soft transition placeholder:text-ink-400 focus:outline-none focus:border-ink-900 focus:shadow-[0_0_0_3px_rgba(184,134,11,0.15)] {{ $monoCls }} {{ $borderCls }}"
        />
    @endif

    @if($error)
        <p class="text-xs font-medium text-rose-600">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-ink-500">{{ $hint }}</p>
    @endif
</div>
