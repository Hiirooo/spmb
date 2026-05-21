<x-layouts.public title="Pendaftaran Berhasil - SPMB">
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 sm:py-24">

        <div class="text-center">
            <div class="mx-auto inline-flex h-16 w-16 items-center justify-center rounded-full border border-ink-200 bg-paper shadow-soft">
                <svg class="h-8 w-8 text-gold-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="mt-6 text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Berhasil Tercatat</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Pendaftaran Anda<br>telah kami terima
            </h1>
            <p class="mx-auto mt-4 max-w-xl text-sm leading-relaxed text-ink-500">
                Simpan nomor pendaftaran berikut dengan baik. Nomor ini akan digunakan
                untuk verifikasi dokumen dan pengumuman hasil seleksi.
            </p>
        </div>

        <div class="mt-12">
            <div class="relative overflow-hidden rounded-lg border-2 border-ink-900 bg-white">
                <div class="absolute inset-0 grain opacity-30"></div>
                <div class="absolute inset-x-0 top-0 h-1 gold-line"></div>
                <div class="absolute inset-x-0 bottom-0 h-1 gold-line"></div>

                <div class="relative px-8 py-12 text-center sm:px-12 sm:py-16">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.4em] text-ink-500">Nomor Pendaftaran Resmi</p>

                    <div class="mt-6 inline-flex items-center justify-center">
                        <span class="h-px w-12 bg-gold-600"></span>
                        <p class="px-4 font-serif text-4xl font-semibold tracking-wide text-ink-900 sm:text-5xl" id="nomor">{{ $nomor }}</p>
                        <span class="h-px w-12 bg-gold-600"></span>
                    </div>

                    <p class="mx-auto mt-8 max-w-md text-xs leading-relaxed text-ink-500">
                        Tunjukkan nomor ini saat verifikasi dokumen, tes seleksi,
                        dan pengecekan status pendaftaran Anda.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                <button id="copyBtn"
                    onclick="navigator.clipboard.writeText(document.getElementById('nomor').textContent.trim()); this.querySelector('.label').textContent='Tersalin'; this.querySelector('svg').innerHTML='<path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; d=&quot;M5 13l4 4L19 7&quot;/>';"
                    class="inline-flex items-center gap-2 rounded-md border border-ink-900 bg-ink-900 px-5 py-2.5 text-sm font-medium text-paper hover:bg-ink-800">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span class="label">Salin Nomor</span>
                </button>
                <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-md border border-ink-300 bg-white px-5 py-2.5 text-sm font-medium text-ink-700 hover:bg-paper">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Bukti
                </button>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-md border border-ink-300 bg-white px-5 py-2.5 text-sm font-medium text-ink-700 hover:bg-paper">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <div class="mt-16 rounded-lg border border-ink-200 bg-white p-8 shadow-soft">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Apa Selanjutnya?</p>
            <h2 class="mt-3 font-serif text-2xl font-semibold text-ink-900">Tahap berikutnya dalam proses Anda</h2>

            @php
            $next = [
                ['n' => '01', 't' => 'Konfirmasi via email', 'd' => 'Kami akan mengirim email konfirmasi pendaftaran ke alamat yang Anda daftarkan dalam 1×24 jam.'],
                ['n' => '02', 't' => 'Verifikasi dokumen', 'd' => 'Tim admin memvalidasi data dan dokumen Anda dalam 1–3 hari kerja.'],
                ['n' => '03', 't' => 'Tes & wawancara', 'd' => 'Anda akan dijadwalkan untuk mengikuti tes seleksi dan sesi wawancara sesuai jalur pendaftaran.'],
            ];
            @endphp

            <ol class="mt-8 space-y-6">
                @foreach($next as $step)
                    <li class="flex items-start gap-5">
                        <span class="flex-shrink-0 inline-flex h-9 w-9 items-center justify-center rounded-full border border-ink-200 bg-paper font-serif text-xs font-semibold text-ink-700">
                            {{ $step['n'] }}
                        </span>
                        <div>
                            <p class="font-serif text-base font-semibold text-ink-900">{{ $step['t'] }}</p>
                            <p class="mt-1 text-sm leading-relaxed text-ink-500">{{ $step['d'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</x-layouts.public>
