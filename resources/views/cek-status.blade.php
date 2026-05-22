<x-layouts.public title="Cek Status Pendaftaran - SPMB Sumsel">
    <div class="mx-auto max-w-2xl px-4 py-12 sm:px-6 sm:py-16">
        <div class="text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Cek Status</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Pantau status<br>pendaftaran Anda
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-ink-500">
                Masukkan nomor pendaftaran dan NIK untuk melihat status terkini tanpa perlu login.
            </p>
        </div>

        <div class="mt-10 rounded-lg border border-ink-200 bg-white p-6 shadow-soft sm:p-8">
            @livewire('cek-status-form')
        </div>

        <div class="mt-6 rounded-lg bg-ink-900 p-6 text-paper">
            <p class="font-serif text-sm font-semibold">Akses portal lengkap?</p>
            <p class="mt-1 text-xs leading-relaxed text-ink-300">
                Login dengan akun Anda untuk akses unggah dokumen, riwayat verifikasi, dan progress real-time.
            </p>
            <a href="{{ route('login') }}" class="mt-3 inline-flex items-center gap-2 text-xs font-medium text-gold-400 hover:text-gold-300">
                Login Pendaftar
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</x-layouts.public>
