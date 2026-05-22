<x-layouts.public title="Portal Pendaftar - SPMB">
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-16">

        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Portal Pendaftar</p>
                <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                    Halo, {{ $user->name }}
                </h1>
                <p class="mt-3 text-sm leading-relaxed text-ink-500">
                    Pantau status pendaftaran Anda dan lengkapi berkas persyaratan SPMB SMA Negeri Sumatera Selatan.
                </p>
            </div>
        </div>

        @if($pendaftar)
            @php
            $statusMap = [
                'baru' => ['label' => 'Pendaftaran Baru', 'color' => 'gray', 'desc' => 'Pendaftaran tercatat. Lengkapi dokumen agar dapat diverifikasi.'],
                'verifikasi' => ['label' => 'Sedang Diverifikasi', 'color' => 'amber', 'desc' => 'Tim panitia sedang memverifikasi data dan dokumen Anda.'],
                'diterima' => ['label' => 'Diterima', 'color' => 'emerald', 'desc' => 'Selamat! Anda dinyatakan diterima. Segera lakukan daftar ulang.'],
                'ditolak' => ['label' => 'Tidak Diterima', 'color' => 'rose', 'desc' => 'Mohon maaf, Anda belum diterima pada periode ini.'],
                'cadangan' => ['label' => 'Cadangan', 'color' => 'sky', 'desc' => 'Anda masuk daftar cadangan. Pengumuman lanjutan dikirim via email.'],
            ];
            $current = $statusMap[$pendaftar->status] ?? $statusMap['baru'];
            $colorClass = [
                'gray' => 'bg-ink-100 text-ink-700 ring-ink-200',
                'amber' => 'bg-amber-50 text-amber-700 ring-amber-200',
                'emerald' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                'rose' => 'bg-rose-50 text-rose-700 ring-rose-200',
                'sky' => 'bg-sky-50 text-sky-700 ring-sky-200',
            ][$current['color']];
            @endphp

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-6">
                    <div class="rounded-lg border border-ink-200 bg-white shadow-soft">
                        <div class="border-b border-ink-200 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-ink-500">Status Pendaftaran</p>
                            <div class="mt-3 flex flex-wrap items-center gap-3">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $colorClass }}">
                                    {{ $current['label'] }}
                                </span>
                            </div>
                            <p class="mt-3 text-sm leading-relaxed text-ink-500">{{ $current['desc'] }}</p>
                        </div>

                        <dl class="grid gap-4 p-6 sm:grid-cols-2">
                            @php
                            $details = [
                                ['k' => 'Nomor Pendaftaran', 'v' => $pendaftar->nomor_pendaftaran, 'mono' => true],
                                ['k' => 'Nama Lengkap', 'v' => $pendaftar->nama_lengkap],
                                ['k' => 'NISN / NIK', 'v' => ($pendaftar->nisn ?? '-').' / '.$pendaftar->nik, 'mono' => true],
                                ['k' => 'Sekolah Tujuan', 'v' => $pendaftar->sekolah_tujuan],
                                ['k' => 'Jalur', 'v' => ucfirst($pendaftar->jalur_pendaftaran)],
                                ['k' => 'Asal Sekolah', 'v' => $pendaftar->asal_sekolah],
                                ['k' => 'Tahun Lulus', 'v' => $pendaftar->tahun_lulus],
                                ['k' => 'Tanggal Daftar', 'v' => $pendaftar->created_at->translatedFormat('d F Y, H:i')],
                            ];
                            @endphp
                            @foreach($details as $d)
                                <div>
                                    <dt class="text-xs font-medium uppercase tracking-wider text-ink-500">{{ $d['k'] }}</dt>
                                    <dd class="mt-1 text-sm {{ ($d['mono'] ?? false) ? 'font-mono font-semibold' : '' }} text-ink-900">{{ $d['v'] }}</dd>
                                </div>
                            @endforeach
                        </dl>

                        @if($pendaftar->catatan)
                            <div class="border-t border-ink-200 bg-paper px-6 py-5">
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-500">Catatan Panitia</p>
                                <p class="mt-2 text-sm leading-relaxed text-ink-700">{{ $pendaftar->catatan }}</p>
                            </div>
                        @endif
                    </div>

                    @if($progress)
                        <div class="rounded-lg border border-ink-200 bg-white p-6 shadow-soft">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-ink-500">Progres Dokumen</p>
                                    <p class="mt-2 font-serif text-2xl font-semibold text-ink-900">
                                        {{ $progress['uploaded'] }} dari {{ $progress['total'] }} dokumen wajib
                                    </p>
                                    <p class="mt-1 text-xs text-ink-500">
                                        {{ $progress['percent'] === 100 ? 'Semua dokumen wajib telah diunggah.' : 'Lengkapi dokumen agar pendaftaran dapat diverifikasi.' }}
                                    </p>
                                </div>
                                <a href="{{ route('portal.dokumen') }}" class="inline-flex items-center gap-2 rounded-md bg-ink-900 px-4 py-2.5 text-sm font-semibold text-paper hover:bg-ink-800">
                                    {{ $progress['uploaded'] === 0 ? 'Mulai Unggah' : 'Kelola Dokumen' }}
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                            <div class="mt-5 h-2 overflow-hidden rounded-full bg-ink-100">
                                <div class="h-full rounded-full bg-gold-600 transition-all" style="width: {{ $progress['percent'] }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="rounded-lg border border-ink-200 bg-white p-6 shadow-soft">
                        <p class="font-serif text-base font-semibold text-ink-900">Aksi</p>
                        <div class="mt-4 space-y-2">
                            <a href="{{ route('portal.dokumen') }}" class="flex items-center justify-between rounded-md border border-ink-200 px-4 py-3 text-sm hover:bg-paper">
                                <span class="text-ink-700">Unggah / Kelola Dokumen</span>
                                <svg class="h-3.5 w-3.5 text-ink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <a href="{{ route('daftar.sukses', ['nomor' => $pendaftar->nomor_pendaftaran]) }}" class="flex items-center justify-between rounded-md border border-ink-200 px-4 py-3 text-sm hover:bg-paper">
                                <span class="text-ink-700">Lihat Bukti Daftar</span>
                                <svg class="h-3.5 w-3.5 text-ink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center justify-between rounded-md border border-ink-200 px-4 py-3 text-sm hover:bg-paper">
                                    <span class="text-ink-700">Keluar</span>
                                    <svg class="h-3.5 w-3.5 text-ink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="rounded-lg bg-ink-900 p-6 text-paper">
                        <p class="font-serif text-base font-semibold">Butuh bantuan?</p>
                        <p class="mt-2 text-xs leading-relaxed text-ink-300">
                            Hubungi tim panitia jika ada kendala teknis atau pertanyaan.
                        </p>
                        <a href="https://wa.me/6281234567890" class="mt-4 inline-flex items-center gap-2 text-xs font-medium text-gold-400 hover:text-gold-300">
                            WhatsApp 0812-3456-7890
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="mt-10 rounded-lg border-2 border-dashed border-ink-200 bg-white p-12 text-center">
                <div class="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-full border border-ink-200 bg-paper">
                    <svg class="h-6 w-6 text-ink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h2 class="mt-6 font-serif text-2xl font-semibold text-ink-900">Belum mendaftar</h2>
                <p class="mt-2 max-w-md mx-auto text-sm leading-relaxed text-ink-500">
                    Anda belum mengisi formulir pendaftaran. Lengkapi data Anda untuk memulai proses seleksi SPMB SMA Negeri Sumsel.
                </p>
                <a href="{{ route('daftar') }}" class="mt-6 inline-flex items-center gap-2 rounded-md bg-ink-900 px-6 py-3 text-sm font-semibold text-paper hover:bg-ink-800">
                    Mulai Pendaftaran
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <div class="mt-6">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-ink-500 underline-offset-4 hover:underline">Keluar dari akun</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-layouts.public>
