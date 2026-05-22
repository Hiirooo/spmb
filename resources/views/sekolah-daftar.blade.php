<x-layouts.public :title="'Form Pendaftaran - ' . $sekolah->nama">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-14">
        <nav class="flex items-center gap-2 text-xs text-ink-500">
            <a href="{{ route('sekolah.index') }}" class="hover:text-ink-900">Sekolah</a>
            <span class="text-ink-300">/</span>
            <a href="{{ route('sekolah.show', ['sekolah' => $sekolah->slug]) }}" class="hover:text-ink-900">{{ $sekolah->nama }}</a>
            <span class="text-ink-300">/</span>
            <span class="text-ink-700">Pendaftaran</span>
        </nav>

        <div class="mt-6 max-w-3xl">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Formulir Pendaftaran</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Daftar ke<br>{{ $sekolah->nama }}
            </h1>
            <p class="mt-4 max-w-xl text-sm leading-relaxed text-ink-500">
                Isi setiap bagian dengan cermat. Pastikan email & nomor telepon aktif.
                @if($jalur)
                    Jalur <span class="font-semibold text-ink-900">{{ ucfirst($jalur) }}</span> telah dipilih dari rekomendasi.
                @endif
            </p>
        </div>

        <div class="mt-12 grid gap-10 lg:grid-cols-12">
            <aside class="lg:col-span-4">
                <div class="lg:sticky lg:top-28 space-y-6">
                    <div class="rounded-lg border border-ink-200 bg-white p-6 shadow-soft">
                        <p class="font-serif text-lg font-semibold text-ink-900">{{ $sekolah->nama }}</p>
                        <p class="mt-1 text-xs text-ink-500">NPSN {{ $sekolah->npsn }} · {{ $sekolah->kabupaten_kota }}</p>

                        <div class="mt-5 space-y-3 text-xs">
                            <div class="flex items-center justify-between border-t border-ink-100 pt-3">
                                <span class="text-ink-500">Jenjang</span>
                                <span class="font-semibold text-ink-900">{{ $sekolah->jenjang }} {{ ucfirst($sekolah->status_negeri) }}</span>
                            </div>
                            <div class="flex items-center justify-between border-t border-ink-100 pt-3">
                                <span class="text-ink-500">Daya Tampung</span>
                                <span class="font-semibold text-ink-900">{{ number_format($sekolah->daya_tampung_total) }} siswa</span>
                            </div>
                        </div>

                        @if(! $jalur)
                            <a href="{{ route('sekolah.rekomendasi', ['sekolah' => $sekolah->slug]) }}" class="mt-5 inline-flex items-center gap-2 text-xs font-medium text-ink-700 hover:text-ink-900">
                                Belum tahu jalur? Cek Rekomendasi
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif
                    </div>

                    <div class="rounded-lg bg-ink-900 p-6 text-paper">
                        <p class="font-serif text-base font-semibold">Butuh bantuan?</p>
                        <p class="mt-1 text-xs leading-relaxed text-ink-300">Hubungi admin sekolah jika ada kendala.</p>
                        @if($sekolah->telepon_kontak)
                            <p class="mt-3 text-xs font-medium text-gold-400">{{ $sekolah->telepon_kontak }}</p>
                        @endif
                    </div>
                </div>
            </aside>

            <div class="lg:col-span-8">
                <div class="rounded-lg border border-ink-200 bg-white shadow-soft">
                    <div class="border-b border-ink-200 px-6 py-5 sm:px-8">
                        <p class="font-serif text-xl font-semibold text-ink-900">Data Pendaftaran</p>
                        <p class="mt-1 text-xs text-ink-500">Semua kolom dengan tanda <span class="text-gold-600">*</span> wajib diisi.</p>
                    </div>
                    <div class="p-6 sm:p-8">
                        @livewire('pendaftaran-form', ['sekolah' => $sekolah, 'jalur' => $jalur])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
