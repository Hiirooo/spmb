<x-layouts.public title="Masuk - SPMB">
    <div class="mx-auto max-w-md px-4 py-16 sm:px-6 sm:py-24">
        <div class="text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Portal Pendaftar</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Selamat datang<br>kembali
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-ink-500">
                Masuk untuk melanjutkan pendaftaran atau mengecek status seleksi Anda.
            </p>
        </div>

        <div class="mt-10 rounded-lg border border-ink-200 bg-white p-6 shadow-soft sm:p-8">
            @livewire('auth.login-form')
        </div>

        <p class="mt-6 text-center text-sm text-ink-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-ink-900 underline-offset-4 hover:underline">Daftar di sini</a>
        </p>
    </div>
</x-layouts.public>
