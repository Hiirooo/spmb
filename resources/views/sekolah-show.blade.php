<x-layouts.public :title="$sekolah->nama . ' - SPMB Sumsel'">
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-16">
        <nav class="flex items-center gap-2 text-xs text-ink-500">
            <a href="{{ route('sekolah.index') }}" class="hover:text-ink-900">Daftar Sekolah</a>
            <span class="text-ink-300">/</span>
            <span class="text-ink-700">{{ $sekolah->nama }}</span>
        </nav>

        <header class="mt-6 flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center rounded-full bg-ink-50 px-2 py-0.5 text-[10px] font-semibold text-ink-700 ring-1 ring-ink-200">{{ $sekolah->jenjang }} {{ ucfirst($sekolah->status_negeri) }}</span>
                    @if($sekolah->is_pendaftaran_buka)
                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 ring-1 ring-emerald-200">Pendaftaran Buka</span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-[10px] font-semibold text-rose-700 ring-1 ring-rose-200">Pendaftaran Tutup</span>
                    @endif
                </div>
                <h1 class="mt-4 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                    {{ $sekolah->nama }}
                </h1>
                <p class="mt-3 text-sm text-ink-500">
                    NPSN {{ $sekolah->npsn }} · {{ $sekolah->kabupaten_kota }}, {{ $sekolah->provinsi }}
                </p>
                @if($sekolah->deskripsi)
                    <p class="mt-4 max-w-2xl text-sm leading-relaxed text-ink-700">{{ $sekolah->deskripsi }}</p>
                @endif
            </div>
            @if($sekolah->is_pendaftaran_buka)
                <div class="flex flex-col gap-2">
                    <a href="{{ route('sekolah.rekomendasi', ['sekolah' => $sekolah->slug]) }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-ink-900 px-5 py-2.5 text-sm font-semibold text-paper shadow-soft hover:bg-ink-800">
                        Cek Rekomendasi Jalur
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @auth
                        <a href="{{ route('sekolah.daftar', ['sekolah' => $sekolah->slug]) }}" class="inline-flex items-center justify-center gap-2 rounded-md border border-ink-300 bg-white px-5 py-2.5 text-sm font-medium text-ink-700 hover:bg-paper">
                            Langsung Daftar
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-md border border-ink-300 bg-white px-5 py-2.5 text-sm font-medium text-ink-700 hover:bg-paper">
                            Buat Akun untuk Daftar
                        </a>
                    @endauth
                </div>
            @endif
        </header>

        <section class="mt-10 grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 rounded-lg border border-ink-200 bg-white shadow-soft">
                <div class="border-b border-ink-200 px-6 py-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-ink-500">Kuota Jalur Pendaftaran</p>
                    <p class="mt-1 text-xs text-ink-500">Total daya tampung: <span class="font-semibold text-ink-900">{{ number_format($sekolah->daya_tampung_total) }}</span> siswa</p>
                </div>
                <div class="divide-y divide-ink-200">
                    @foreach($stats as $key => $stat)
                        <div class="px-6 py-5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="font-serif text-base font-semibold text-ink-900">{{ $stat['label'] }}</h3>
                                        @if($stat['persen_terisi'] >= 100)
                                            <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-[10px] font-semibold text-rose-700 ring-1 ring-rose-200">PENUH</span>
                                        @elseif($stat['persen_terisi'] >= 80)
                                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700 ring-1 ring-amber-200">Hampir Penuh</span>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-xs text-ink-500">{{ $stat['persentase'] }}% dari daya tampung · kuota {{ $stat['kuota'] }} kursi</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-mono text-xl font-semibold text-ink-900">{{ $stat['terisi'] }}/{{ $stat['kuota'] }}</p>
                                    <p class="text-xs text-ink-500">terisi</p>
                                </div>
                            </div>
                            <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-ink-100">
                                <div class="h-full {{ $stat['persen_terisi'] >= 100 ? 'bg-rose-500' : ($stat['persen_terisi'] >= 80 ? 'bg-amber-500' : 'bg-ink-900') }}" style="width: {{ min($stat['persen_terisi'], 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-lg border border-ink-200 bg-white p-6 shadow-soft">
                    <p class="font-serif text-base font-semibold text-ink-900">Kontak</p>
                    <dl class="mt-4 space-y-3 text-sm">
                        @if($sekolah->alamat)
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-500">Alamat</dt>
                                <dd class="mt-1 text-ink-700">{{ $sekolah->alamat }}</dd>
                            </div>
                        @endif
                        @if($sekolah->email_kontak)
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-500">Email</dt>
                                <dd class="mt-1 text-ink-700">{{ $sekolah->email_kontak }}</dd>
                            </div>
                        @endif
                        @if($sekolah->telepon_kontak)
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-500">Telepon</dt>
                                <dd class="mt-1 text-ink-700">{{ $sekolah->telepon_kontak }}</dd>
                            </div>
                        @endif
                        @if($sekolah->website)
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-500">Website</dt>
                                <dd class="mt-1"><a href="{{ $sekolah->website }}" target="_blank" rel="noopener" class="text-ink-900 underline-offset-4 hover:underline">{{ $sekolah->website }}</a></dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div class="rounded-lg bg-ink-900 p-6 text-paper">
                    <p class="font-serif text-sm font-semibold">Total Pendaftar</p>
                    <p class="mt-2 font-serif text-3xl font-semibold">{{ number_format($totalPendaftar) }}</p>
                    <p class="mt-1 text-xs text-ink-300">Sudah terdaftar di sistem ini</p>
                </div>
            </div>
        </section>
    </div>
</x-layouts.public>
