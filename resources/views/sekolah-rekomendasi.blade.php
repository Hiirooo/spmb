<x-layouts.public :title="'Rekomendasi Jalur - ' . $sekolah->nama">
    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 sm:py-16">
        <nav class="flex items-center gap-2 text-xs text-ink-500">
            <a href="{{ route('sekolah.index') }}" class="hover:text-ink-900">Daftar Sekolah</a>
            <span class="text-ink-300">/</span>
            <a href="{{ route('sekolah.show', ['sekolah' => $sekolah->slug]) }}" class="hover:text-ink-900">{{ $sekolah->nama }}</a>
            <span class="text-ink-300">/</span>
            <span class="text-ink-700">Rekomendasi Jalur</span>
        </nav>

        <div class="mt-6">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Asesmen Jalur</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Cari jalur paling cocok<br>untuk Anda
            </h1>
            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-ink-500">
                Jawab 10 pertanyaan singkat. Sistem akan menghitung skor kecocokan untuk
                4 jalur SPMB SMA Negeri Sumsel: Afirmasi, Domisili, Mutasi, dan Prestasi —
                berdasarkan Juknis Disdik Sumsel TA {{ date('Y') }}/{{ date('Y') + 1 }}.
            </p>
        </div>

        <div class="mt-10">
            @livewire('sekolah.rekomendasi-jalur', ['sekolah' => $sekolah])
        </div>
    </div>
</x-layouts.public>
