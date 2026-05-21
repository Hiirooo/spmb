<x-layouts.public title="Form Pendaftaran - SPMB">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-14">

        <nav class="flex items-center gap-2 text-xs text-ink-500">
            <a href="{{ route('home') }}" class="hover:text-ink-900">Beranda</a>
            <span class="text-ink-300">/</span>
            <span class="text-ink-700">Pendaftaran</span>
        </nav>

        <div class="mt-6 max-w-3xl">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Formulir Pendaftaran</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Lengkapi data Anda<br>dalam empat langkah
            </h1>
            <p class="mt-4 max-w-xl text-sm leading-relaxed text-ink-500">
                Isi setiap bagian dengan cermat. Pastikan email dan nomor telepon aktif —
                pengumuman hasil seleksi dikirim ke alamat tersebut.
            </p>
        </div>

        <div class="mt-12 grid gap-10 lg:grid-cols-12">
            <aside class="lg:col-span-4">
                <div class="lg:sticky lg:top-28">
                    <div class="rounded-lg border border-ink-200 bg-white p-6 shadow-soft">
                        <p class="font-serif text-lg font-semibold text-ink-900">Panduan</p>
                        <p class="mt-1 text-xs leading-relaxed text-ink-500">
                            Seluruh data akan diverifikasi. Pastikan tidak ada kesalahan ketik.
                        </p>

                        <ol class="mt-6 space-y-5 border-l border-ink-200 pl-5">
                            <li class="relative">
                                <span class="absolute -left-[27px] flex h-4 w-4 items-center justify-center rounded-full border border-gold-600 bg-paper">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gold-600"></span>
                                </span>
                                <p class="font-serif text-sm font-semibold text-ink-900">Identitas</p>
                                <p class="mt-1 text-xs text-ink-500">Data pribadi & kartu identitas</p>
                            </li>
                            <li class="relative">
                                <span class="absolute -left-[27px] flex h-4 w-4 items-center justify-center rounded-full border border-ink-300 bg-paper"></span>
                                <p class="font-serif text-sm font-semibold text-ink-700">Kontak</p>
                                <p class="mt-1 text-xs text-ink-500">Email & nomor telepon</p>
                            </li>
                            <li class="relative">
                                <span class="absolute -left-[27px] flex h-4 w-4 items-center justify-center rounded-full border border-ink-300 bg-paper"></span>
                                <p class="font-serif text-sm font-semibold text-ink-700">Pendidikan</p>
                                <p class="mt-1 text-xs text-ink-500">Sekolah asal & tahun lulus</p>
                            </li>
                            <li class="relative">
                                <span class="absolute -left-[27px] flex h-4 w-4 items-center justify-center rounded-full border border-ink-300 bg-paper"></span>
                                <p class="font-serif text-sm font-semibold text-ink-700">Pilihan</p>
                                <p class="mt-1 text-xs text-ink-500">Program studi & jalur</p>
                            </li>
                        </ol>
                    </div>

                    <div class="mt-6 rounded-lg bg-ink-900 p-6 text-paper">
                        <p class="font-serif text-base font-semibold">Butuh bantuan?</p>
                        <p class="mt-1 text-xs leading-relaxed text-ink-300">
                            Tim admin siap membantu jika Anda mengalami kendala.
                        </p>
                        <a href="https://wa.me/6281234567890" class="mt-4 inline-flex items-center gap-2 text-xs font-medium text-gold-400 hover:text-gold-300">
                            WhatsApp 0812-3456-7890
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
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
                        @livewire('pendaftaran-form')
                    </div>
                </div>

                <p class="mt-6 text-center text-xs text-ink-500">
                    Dengan mendaftar, Anda menyetujui ketentuan & kebijakan privasi SPMB.
                </p>
            </div>
        </div>
    </div>
</x-layouts.public>
