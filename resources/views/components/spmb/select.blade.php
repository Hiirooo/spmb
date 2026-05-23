@props([
    'name',
    'label',
    'options' => [],
    'placeholder' => 'Pilih salah satu',
    'required' => false,
    'hint' => null,
    'span' => 1,
])

@php
    $error = $errors->first($name);
    $colSpan = $span === 2 ? 'sm:col-span-2' : '';
    $hasError = $error !== null;

    $opts = collect($options)->map(function ($opt) {
        if (is_array($opt)) {
            return $opt + ['penuh' => $opt['penuh'] ?? false];
        }
        return ['value' => $opt, 'label' => $opt, 'penuh' => false];
    })->values()->all();
@endphp

<div class="flex flex-col gap-1.5 {{ $colSpan }}">
    <label class="text-sm font-semibold text-ink-800">
        {{ $label }}
        @if($required)<span class="ml-0.5 text-gold-600">*</span>@endif
    </label>

    <div
        x-data="{
            open: false,
            value: @entangle($name).live,
            options: @js($opts),
            get current() { return this.options.find(o => o.value === this.value); },
            select(opt) {
                if (opt.penuh) return;
                this.value = opt.value;
                this.$nextTick(() => { this.open = false; });
            },
        }"
        @click.outside="open = false"
        @keydown.escape.window="open = false"
        class="relative"
    >
        <button
            type="button"
            @click.prevent="open = !open"
            :class="open ? 'border-ink-900 shadow-[0_0_0_3px_rgba(184,134,11,0.15)]' : '{{ $hasError ? 'border-rose-400' : 'border-ink-200' }}'"
            class="flex w-full items-center justify-between gap-2 rounded-lg border bg-white px-3.5 py-2.5 text-left text-[15px] text-ink-900 shadow-soft transition hover:border-ink-300 focus:outline-none"
        >
            <span x-show="current" x-text="current?.label" class="truncate"></span>
            <span x-show="!current" class="text-ink-400">{{ $placeholder }}</span>
            <svg class="h-4 w-4 flex-shrink-0 text-ink-400 transition" :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-cloak
            class="absolute left-0 right-0 z-30 mt-1.5 max-h-60 overflow-y-auto rounded-lg border border-ink-200 bg-white p-1 shadow-lift"
        >
            <template x-for="opt in options" :key="opt.value">
                <button
                    type="button"
                    @click.stop.prevent="select(opt)"
                    :disabled="opt.penuh"
                    :class="{
                        'bg-ink-900 text-paper': value === opt.value,
                        'hover:bg-paper text-ink-800': value !== opt.value && !opt.penuh,
                        'opacity-40 cursor-not-allowed text-ink-400': opt.penuh,
                    }"
                    class="flex w-full items-center justify-between gap-2 rounded-md px-3 py-2 text-left text-[14px] transition"
                >
                    <span x-text="opt.label" class="truncate"></span>
                    <span x-show="opt.penuh" class="ml-2 inline-flex items-center rounded-full bg-rose-100 px-1.5 py-0.5 text-[9px] font-semibold uppercase tracking-wide text-rose-700">Penuh</span>
                    <svg x-show="value === opt.value && !opt.penuh" class="h-3.5 w-3.5 flex-shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </button>
            </template>
        </div>
    </div>

    @if($error)
        <p class="text-xs font-medium text-rose-600">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-ink-500">{{ $hint }}</p>
    @endif
</div>
