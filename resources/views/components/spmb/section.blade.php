@props([
    'title',
    'description' => null,
    'number' => null,
])

<section {{ $attributes->merge(['class' => 'rounded-xl border border-ink-200 bg-white shadow-soft']) }}>
    <header class="border-b border-ink-200 px-6 py-5 sm:px-8">
        <div class="flex items-start gap-4">
            @if($number)
                <span class="inline-flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full border border-gold-600/40 bg-gold-50 font-serif text-sm font-semibold text-gold-700">
                    {{ $number }}
                </span>
            @endif
            <div class="flex-1">
                <h2 class="font-serif text-xl font-semibold text-ink-900">{{ $title }}</h2>
                @if($description)
                    <p class="mt-1 text-xs leading-relaxed text-ink-500">{{ $description }}</p>
                @endif
            </div>
        </div>
    </header>
    <div class="grid gap-5 p-6 sm:p-8 sm:grid-cols-2">
        {{ $slot }}
    </div>
</section>
