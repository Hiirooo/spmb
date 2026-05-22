<x-layouts.public title="Daftarkan Sekolah - SPMB Sumsel">
    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-16">
        <div class="text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Untuk Pihak Sekolah</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Daftarkan sekolah Anda<br>ke platform SPMB
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-ink-500">
                Sekolah yang terdaftar mendapatkan portal pengelolaan pendaftaran,
                verifikasi dokumen, statistik real-time, dan dashboard admin sendiri — gratis.
            </p>
        </div>

        <div class="mt-10 rounded-lg border border-ink-200 bg-white p-6 shadow-soft sm:p-8">
            @livewire('sekolah.register-sekolah-form')
        </div>

        <p class="mt-6 text-center text-sm text-ink-500">
            Sudah terdaftar?
            <a href="{{ route('login') }}" class="font-medium text-ink-900 underline-offset-4 hover:underline">Masuk sebagai admin sekolah</a>
        </p>
    </div>
</x-layouts.public>
