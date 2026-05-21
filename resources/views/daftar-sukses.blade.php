<x-layouts.public title="Pendaftaran Berhasil - SPMB">
    <div class="mx-auto max-w-2xl text-center py-12">
        <div class="mx-auto inline-flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-green-600">
            <svg class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="mt-6 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
            Pendaftaran Berhasil!
        </h1>
        <p class="mt-3 text-lg text-slate-600">
            Terima kasih telah mendaftar. Simpan nomor pendaftaran berikut untuk keperluan verifikasi.
        </p>

        <div class="mt-8 rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200/60">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Nomor Pendaftaran</p>
            <p class="mt-2 select-all font-mono text-3xl font-bold text-amber-600 sm:text-4xl" id="nomor">{{ $nomor }}</p>
            <p class="mt-4 text-sm text-slate-500">
                Tim admin akan memverifikasi pendaftaran Anda dalam 1-3 hari kerja. Pengumuman dikirim via email/WhatsApp.
            </p>
        </div>

        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-3 font-semibold text-slate-700 hover:bg-slate-50">
                Kembali ke Beranda
            </a>
            <button onclick="navigator.clipboard.writeText(document.getElementById('nomor').textContent.trim()); this.textContent='Tersalin ✓'" class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-6 py-3 font-semibold text-white hover:bg-amber-400">
                Salin Nomor
            </button>
        </div>
    </div>
</x-layouts.public>
