<div>
    @if(! $pendaftar && ! $notFound)
        <form wire:submit="submit" class="space-y-5">
            <x-spmb.input
                name="nomor_pendaftaran"
                label="Nomor Pendaftaran"
                placeholder="Mis: SMAN5001-2026-00001"
                :required="true"
                :autofocus="true"
                mono
            />

            <x-spmb.input
                name="nik"
                label="NIK (16 digit)"
                placeholder="Sesuai Kartu Keluarga"
                inputmode="numeric"
                maxlength="16"
                :required="true"
                mono
            />

            <x-spmb.submit target="submit" label="Cek Status" :fullWidth="true" />
        </form>
    @elseif($notFound)
        <div class="text-center py-6">
            <div class="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-full bg-rose-50 text-rose-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <h3 class="mt-4 font-serif text-xl font-semibold text-ink-900">Data tidak ditemukan</h3>
            <p class="mt-2 text-sm text-ink-500">Nomor pendaftaran dan NIK tidak cocok. Periksa kembali atau hubungi admin sekolah.</p>
            <button wire:click="reset_form" class="mt-6 inline-flex items-center gap-2 rounded-lg border border-ink-200 bg-white px-4 py-2 text-sm font-medium text-ink-700 shadow-soft hover:bg-paper">Coba Lagi</button>
        </div>
    @else
        @php
            $statusMap = [
                'baru' => ['label' => 'Pendaftaran Baru', 'color' => 'gray', 'desc' => 'Pendaftaran tercatat, menunggu verifikasi.'],
                'verifikasi' => ['label' => 'Sedang Diverifikasi', 'color' => 'amber', 'desc' => 'Tim panitia memverifikasi dokumen Anda.'],
                'diterima' => ['label' => 'Diterima', 'color' => 'emerald', 'desc' => 'Selamat! Anda dinyatakan diterima.'],
                'ditolak' => ['label' => 'Tidak Diterima', 'color' => 'rose', 'desc' => 'Anda belum diterima pada periode ini.'],
                'cadangan' => ['label' => 'Cadangan', 'color' => 'sky', 'desc' => 'Anda masuk daftar cadangan.'],
            ];
            $current = $statusMap[$pendaftar->status] ?? $statusMap['baru'];
            $colorClass = [
                'gray' => 'bg-ink-100 text-ink-700 ring-ink-200',
                'amber' => 'bg-amber-50 text-amber-700 ring-amber-200',
                'emerald' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                'rose' => 'bg-rose-50 text-rose-700 ring-rose-200',
                'sky' => 'bg-sky-50 text-sky-700 ring-sky-200',
            ][$current['color']];

            $totalDok = $pendaftar->dokumens->count();
            $diterimaDok = $pendaftar->dokumens->where('status', 'diterima')->count();
        @endphp

        <div class="space-y-5">
            <div class="text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-ink-500">Nomor Pendaftaran</p>
                <p class="mt-2 font-mono text-2xl font-bold text-ink-900">{{ $pendaftar->nomor_pendaftaran }}</p>
            </div>

            <div class="rounded-lg border-2 border-ink-200 bg-paper p-5 text-center">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $colorClass }}">
                    {{ $current['label'] }}
                </span>
                <p class="mt-3 text-sm text-ink-600">{{ $current['desc'] }}</p>
            </div>

            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="rounded-md border border-ink-200 bg-white p-3">
                    <p class="text-[10px] font-medium uppercase tracking-wide text-ink-500">Nama</p>
                    <p class="mt-1 font-medium text-ink-900">{{ $pendaftar->nama_lengkap }}</p>
                </div>
                <div class="rounded-md border border-ink-200 bg-white p-3">
                    <p class="text-[10px] font-medium uppercase tracking-wide text-ink-500">Sekolah Tujuan</p>
                    <p class="mt-1 font-medium text-ink-900">{{ $pendaftar->sekolah?->nama ?? $pendaftar->sekolah_tujuan }}</p>
                </div>
                <div class="rounded-md border border-ink-200 bg-white p-3">
                    <p class="text-[10px] font-medium uppercase tracking-wide text-ink-500">Jalur</p>
                    <p class="mt-1 font-medium text-ink-900">{{ ucfirst($pendaftar->jalur_pendaftaran) }}</p>
                </div>
                <div class="rounded-md border border-ink-200 bg-white p-3">
                    <p class="text-[10px] font-medium uppercase tracking-wide text-ink-500">Tanggal Daftar</p>
                    <p class="mt-1 font-medium text-ink-900">{{ $pendaftar->created_at->translatedFormat('d M Y') }}</p>
                </div>
            </div>

            @if($totalDok > 0)
                <div class="rounded-md border border-ink-200 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-ink-500">Progres Dokumen</p>
                    <p class="mt-2 text-sm text-ink-900">
                        <span class="font-semibold">{{ $diterimaDok }}</span> dari {{ $totalDok }} dokumen telah diverifikasi
                    </p>
                </div>
            @endif

            <button wire:click="reset_form" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-ink-200 bg-white px-4 py-2.5 text-sm font-medium text-ink-700 shadow-soft hover:bg-paper">
                Cek Nomor Lain
            </button>
        </div>
    @endif
</div>
