@php
    $colorMap = [
        'afirmasi' => ['emerald', 'bg-emerald-500'],
        'domisili' => ['gray', 'bg-gray-700'],
        'mutasi' => ['amber', 'bg-amber-500'],
        'prestasi' => ['sky', 'bg-sky-500'],
    ];
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Kuota Pendaftaran per Jalur</x-slot>
        <x-slot name="description">
            @if($sekolah)
                {{ $sekolah->nama }} · Daya tampung total: {{ number_format($totalKuota) }} kursi · {{ number_format($totalPendaftar) }} pendaftar masuk
            @else
                Tidak terhubung ke sekolah.
            @endif
        </x-slot>

        @if(empty($stats))
            <div class="rounded-lg border border-dashed border-gray-300 dark:border-gray-700 px-6 py-10 text-center text-sm text-gray-500">
                Tidak ada data kuota.
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($stats as $key => $stat)
                    @php $color = $colorMap[$key] ?? ['gray', 'bg-gray-500']; @endphp
                    <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $stat['label'] }}</p>
                                <p class="mt-1 text-[10px] text-gray-400">{{ $stat['persentase'] }}% kuota</p>
                            </div>
                            @if($stat['penuh'])
                                <span class="inline-flex items-center rounded-full bg-rose-100 px-2 py-0.5 text-[10px] font-semibold text-rose-700">PENUH</span>
                            @elseif($stat['persen'] >= 80)
                                <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-semibold text-amber-700">Hampir Penuh</span>
                            @endif
                        </div>

                        <div class="mt-4 flex items-baseline gap-2">
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stat['terisi'] }}</p>
                            <p class="text-sm text-gray-400">/ {{ $stat['kuota'] }} kursi</p>
                        </div>

                        <div class="mt-3 h-2 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                            <div class="h-full {{ $color[1] }} transition-all"
                                 style="width: {{ min($stat['persen'], 100) }}%"></div>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-xs">
                            <span class="text-gray-500">Sisa: <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stat['sisa'] }}</span></span>
                            <span class="text-gray-500">Diterima: <span class="font-semibold text-emerald-600">{{ $stat['diterima'] }}</span></span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
