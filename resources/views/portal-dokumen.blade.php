<x-layouts.public title="Unggah Dokumen - SPMB">
    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 sm:py-16">

        <nav class="flex items-center gap-2 text-xs text-ink-500">
            <a href="{{ route('portal') }}" class="hover:text-ink-900">Portal</a>
            <span class="text-ink-300">/</span>
            <span class="text-ink-700">Unggah Dokumen</span>
        </nav>

        <div class="mt-6">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Berkas Pendaftaran</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Unggah dokumen<br>persyaratan
            </h1>
            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-ink-500">
                Unggah seluruh dokumen wajib sesuai jalur <span class="font-semibold text-ink-900 capitalize">{{ $pendaftar->jalur_pendaftaran }}</span>.
                Pastikan dokumen jelas terbaca, format PDF/JPG/PNG, ukuran maksimal {{ \App\Support\SpmbDokumen::MAX_SIZE_MB }} MB per file.
                Dokumen yang sudah diverifikasi tidak dapat diubah.
            </p>
        </div>

        <div class="mt-10">
            @livewire('upload-dokumen')
        </div>

        <div class="mt-10 flex flex-wrap items-center justify-between gap-3 border-t border-ink-200 pt-6">
            <a href="{{ route('portal') }}" class="text-sm text-ink-700 hover:underline">&larr; Kembali ke Portal</a>
            <p class="text-xs text-ink-500">Berdasarkan Juknis SPMB SMA Negeri Provinsi Sumsel TA {{ date('Y') }}/{{ date('Y') + 1 }}</p>
        </div>
    </div>
</x-layouts.public>
