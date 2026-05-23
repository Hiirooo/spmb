@props([
    'target' => 'submit',
    'label' => 'Kirim',
    'fullWidth' => false,
])

@php
    $widthCls = $fullWidth ? 'w-full' : '';
@endphp

<button type="submit"
    wire:loading.attr="disabled"
    wire:target="{{ $target }}"
    class="group inline-flex {{ $widthCls }} items-center justify-center gap-2 rounded-lg bg-ink-900 px-6 py-3 text-sm font-semibold text-paper shadow-soft transition hover:bg-ink-800 focus:outline-none focus:shadow-[0_0_0_3px_rgba(184,134,11,0.25)] disabled:opacity-60 disabled:cursor-not-allowed">
    <svg wire:loading wire:target="{{ $target }}" class="-ml-1 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>
    <span>{{ $label }}</span>
    <svg wire:loading.remove wire:target="{{ $target }}" class="h-3.5 w-3.5 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
</button>
