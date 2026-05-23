<x-layouts.public title="Pengumuman SPMB - Sumsel">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <div class="text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Pengumuman Hasil Seleksi</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Pengumuman SPMB<br>SMA Negeri Sumsel
            </h1>
            <p class="mt-4 max-w-xl mx-auto text-sm leading-relaxed text-ink-500">
                Lihat daftar calon murid yang dinyatakan diterima per sekolah. Pilih sekolah untuk melihat detail pengumuman.
            </p>
        </div>

        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($sekolahs as $s)
                <a href="{{ route('pengumuman.sekolah', ['sekolah' => $s->slug]) }}" class="group rounded-lg border border-ink-200 bg-white p-6 shadow-soft transition hover:-translate-y-0.5 hover:shadow-card">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-gold-600">{{ $s->kabupaten_kota }}</p>
                    <h2 class="mt-3 font-serif text-lg font-semibold text-ink-900 group-hover:text-ink-700">{{ $s->nama }}</h2>
                    <div class="mt-4 flex items-center justify-between text-sm">
                        <div>
                            <p class="font-mono text-2xl font-semibold text-ink-900">{{ $s->diterima_count }}</p>
                            <p class="text-xs text-ink-500">murid diterima</p>
                        </div>
                        <span class="font-medium text-ink-700 group-hover:translate-x-0.5 transition inline-flex items-center gap-1">
                            Lihat
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>
            @empty
                <div class="sm:col-span-2 lg:col-span-3 text-center py-12">
                    <p class="text-sm text-ink-500">Belum ada sekolah dengan pengumuman.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $sekolahs->links() }}</div>
    </div>
</x-layouts.public>
