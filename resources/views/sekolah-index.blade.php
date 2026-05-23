<x-layouts.public title="Daftar Sekolah - SPMB Sumsel">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Direktori</p>
                <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                    Pilih sekolah tujuan
                </h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-ink-500">
                    {{ $sekolahs->total() }} sekolah aktif menerima pendaftaran. Pilih sekolah lalu lanjutkan dengan asesmen jalur dan formulir pendaftaran.
                </p>
            </div>
            <a href="{{ route('sekolah.register') }}" class="inline-flex items-center gap-2 rounded-md border border-ink-300 bg-white px-4 py-2.5 text-sm font-medium text-ink-700 hover:bg-paper">
                Daftarkan Sekolah Baru
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            </a>
        </div>

        <form method="GET" class="mt-8 grid gap-3 sm:grid-cols-[1fr_auto_auto]">
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-ink-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                </span>
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama sekolah, NPSN, atau wilayah..."
                    class="w-full rounded-lg border-ink-200 bg-white py-2.5 pl-10 pr-4 text-sm text-ink-900 shadow-soft placeholder:text-ink-400 focus:border-ink-900 focus:shadow-[0_0_0_3px_rgba(184,134,11,0.15)] focus:ring-0" />
            </div>
            <select name="kab" class="rounded-lg border-ink-200 bg-white px-4 py-2.5 text-sm text-ink-900 shadow-soft focus:border-ink-900 focus:shadow-[0_0_0_3px_rgba(184,134,11,0.15)] focus:ring-0">
                <option value="">Semua Kab/Kota</option>
                @foreach($kabupatens as $kabName)
                    <option value="{{ $kabName }}" @selected($kab === $kabName)>{{ $kabName }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-lg bg-ink-900 px-6 py-2.5 text-sm font-semibold text-paper shadow-soft hover:bg-ink-800 transition">Cari</button>
        </form>

        @if($sekolahs->isEmpty())
            <div class="mt-12 rounded-lg border-2 border-dashed border-ink-200 bg-white p-12 text-center">
                <p class="font-serif text-lg font-semibold text-ink-900">Belum ada sekolah yang cocok</p>
                <p class="mt-2 text-sm text-ink-500">Coba kata kunci atau wilayah lain.</p>
            </div>
        @else
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($sekolahs as $s)
                    <a href="{{ route('sekolah.show', ['sekolah' => $s->slug]) }}" class="group rounded-lg border border-ink-200 bg-white p-6 shadow-soft transition hover:-translate-y-0.5 hover:shadow-card">
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center rounded-full bg-ink-50 px-2 py-0.5 text-[10px] font-semibold text-ink-700 ring-1 ring-ink-200">{{ $s->jenjang }} {{ ucfirst($s->status_negeri) }}</span>
                            @if($s->is_pendaftaran_buka)
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 ring-1 ring-emerald-200">Buka</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-[10px] font-semibold text-rose-700 ring-1 ring-rose-200">Tutup</span>
                            @endif
                        </div>
                        <h2 class="mt-4 font-serif text-lg font-semibold text-ink-900 group-hover:text-ink-700">{{ $s->nama }}</h2>
                        <p class="mt-1 text-xs text-ink-500">{{ $s->kabupaten_kota }} · NPSN {{ $s->npsn }}</p>
                        @if($s->deskripsi)
                            <p class="mt-3 text-xs leading-relaxed text-ink-500 line-clamp-2">{{ $s->deskripsi }}</p>
                        @endif
                        <div class="mt-4 flex items-center justify-between text-xs">
                            <span class="text-ink-500">Daya tampung: <span class="font-semibold text-ink-900">{{ number_format($s->daya_tampung_total) }}</span></span>
                            <span class="font-medium text-ink-700 group-hover:translate-x-0.5 transition inline-flex items-center gap-1">
                                Detail
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $sekolahs->links() }}
            </div>
        @endif
    </div>
</x-layouts.public>
