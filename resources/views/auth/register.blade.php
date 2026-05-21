<x-layouts.public title="Buat Akun - SPMB">
    <div class="mx-auto max-w-md px-4 py-16 sm:px-6 sm:py-24">
        <div class="text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Buat Akun</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Mulai perjalanan<br>akademik Anda
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-ink-500">
                Buat akun untuk mendaftar SPMB dan memantau status pendaftaran Anda.
            </p>
        </div>

        <div class="mt-10 rounded-lg border border-ink-200 bg-white p-6 shadow-soft sm:p-8">
            @livewire('auth.register-form')
        </div>

        <p class="mt-6 text-center text-sm text-ink-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-ink-900 underline-offset-4 hover:underline">Masuk di sini</a>
        </p>
    </div>
</x-layouts.public>
