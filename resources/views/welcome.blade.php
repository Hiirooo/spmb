<x-layouts.public title="SPMB - Penerimaan Mahasiswa Baru">

    <section class="relative overflow-hidden bg-ink-900 text-paper">
        <div class="absolute inset-0 grain opacity-40"></div>
        <div class="absolute inset-x-0 top-0 h-px gold-line"></div>
        <div class="absolute inset-x-0 bottom-0 h-px gold-line opacity-50"></div>

        <div class="relative mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28 lg:py-32">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-gold-600/30 bg-gold-600/10 px-3 py-1 text-xs uppercase tracking-[0.2em] text-gold-400">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-gold-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-gold-500"></span>
                    </span>
                    Pendaftaran {{ date('Y') }} Dibuka
                </div>

                <h1 class="mt-8 font-serif text-5xl font-semibold leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">
                    Jalan Anda Menuju<br>
                    Pendidikan Tinggi<br>
                    <span class="italic text-gold-500">Dimulai Di Sini.</span>
                </h1>

                <p class="mt-8 max-w-xl text-lg leading-relaxed text-ink-300">
                    Daftar secara online dengan proses yang transparan dan terverifikasi.
                    Dapatkan nomor pendaftaran instan dan pantau status seleksi Anda.
                </p>

                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <a href="{{ route('daftar') }}" class="group inline-flex items-center gap-2 rounded-md bg-gold-600 px-6 py-3.5 text-sm font-semibold text-ink-950 shadow-soft transition hover:bg-gold-500">
                        Mulai Pendaftaran
                        <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="#program" class="inline-flex items-center gap-2 rounded-md border border-ink-700 bg-ink-800/40 px-6 py-3.5 text-sm font-medium text-paper transition hover:bg-ink-800">
                        Pelajari Program
                    </a>
                </div>
            </div>

            <div class="mt-20 grid grid-cols-2 gap-px overflow-hidden rounded-lg bg-ink-700 lg:grid-cols-4">
                @php
                $heroStats = [
                    ['label' => 'Total Pendaftar', 'value' => $totalPendaftar, 'desc' => 'pendaftaran masuk'],
                    ['label' => 'Telah Diterima', 'value' => $diterima, 'desc' => 'lulus seleksi'],
                    ['label' => 'Sedang Diverifikasi', 'value' => $verifikasi, 'desc' => 'dalam proses'],
                    ['label' => 'Program Studi', 'value' => 6, 'desc' => 'tersedia'],
                ];
                @endphp
                @foreach($heroStats as $stat)
                    <div class="bg-ink-900 px-6 py-6">
                        <p class="font-serif text-4xl font-semibold text-paper">{{ number_format($stat['value']) }}</p>
                        <p class="mt-1 text-sm font-medium text-ink-200">{{ $stat['label'] }}</p>
                        <p class="text-xs text-ink-400">{{ $stat['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="program" class="relative bg-paper">
        <div class="mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28">
            <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Program Studi</p>
                    <h2 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                        Enam pilihan akademik<br>untuk membangun masa depan
                    </h2>
                </div>
                <p class="max-w-sm text-sm leading-relaxed text-ink-500">
                    Setiap program disusun dengan kurikulum berbasis kompetensi dan pengajar berpengalaman di bidangnya.
                </p>
            </div>

            @php
            $prodi = [
                ['name' => 'Teknik Informatika', 'desc' => 'Kembangkan solusi digital dengan pemrograman, AI, dan rekayasa perangkat lunak.', 'tag' => 'Sains & Teknologi'],
                ['name' => 'Sistem Informasi', 'desc' => 'Padukan teknologi informasi dengan strategi bisnis untuk transformasi digital.', 'tag' => 'Sains & Teknologi'],
                ['name' => 'Manajemen', 'desc' => 'Kuasai pengelolaan organisasi, keuangan, dan strategi kepemimpinan.', 'tag' => 'Bisnis'],
                ['name' => 'Akuntansi', 'desc' => 'Pelajari pelaporan keuangan, audit, dan perpajakan profesional.', 'tag' => 'Bisnis'],
                ['name' => 'Hukum', 'desc' => 'Memahami sistem hukum, advokasi, dan keadilan dalam masyarakat.', 'tag' => 'Sosial Humaniora'],
                ['name' => 'Psikologi', 'desc' => 'Eksplorasi perilaku manusia, kognisi, dan kesehatan mental.', 'tag' => 'Sosial Humaniora'],
            ];
            @endphp

            <div class="mt-16 grid gap-px overflow-hidden rounded-lg bg-ink-200 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($prodi as $p)
                    <div class="group relative bg-paper p-8 transition hover:bg-white">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-gold-600">{{ $p['tag'] }}</p>
                        <h3 class="mt-4 font-serif text-2xl font-semibold text-ink-900">{{ $p['name'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-ink-500">{{ $p['desc'] }}</p>
                        <div class="mt-6 flex items-center gap-2 text-xs font-medium text-ink-700">
                            <span>Pelajari Detail</span>
                            <svg class="h-3 w-3 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="timeline" class="relative bg-ink-900 text-paper">
        <div class="mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-500">Timeline</p>
                <h2 class="mt-3 font-serif text-4xl font-semibold tracking-tight sm:text-5xl">
                    Lima langkah menuju<br>menjadi mahasiswa
                </h2>
            </div>

            @php
            $steps = [
                ['num' => '01', 'title' => 'Pendaftaran', 'desc' => 'Isi data diri & pilih program studi secara online.'],
                ['num' => '02', 'title' => 'Verifikasi', 'desc' => 'Tim admin memvalidasi dokumen Anda dalam 1–3 hari.'],
                ['num' => '03', 'title' => 'Tes Seleksi', 'desc' => 'Mengikuti tes akademik & potensi sesuai jadwal.'],
                ['num' => '04', 'title' => 'Wawancara', 'desc' => 'Sesi diskusi dengan tim seleksi program studi.'],
                ['num' => '05', 'title' => 'Pengumuman', 'desc' => 'Hasil dikirim via email dan dapat dicek di portal.'],
            ];
            @endphp

            <div class="mt-16 grid gap-12 sm:grid-cols-2 lg:grid-cols-5">
                @foreach($steps as $i => $step)
                    <div class="relative">
                        @if(! $loop->last)
                            <div class="absolute left-[34px] top-3 hidden h-px w-full bg-ink-700 lg:block"></div>
                        @endif
                        <div class="relative inline-flex h-7 w-7 items-center justify-center rounded-full border border-gold-600/40 bg-ink-900 font-serif text-xs font-semibold text-gold-500">
                            {{ $step['num'] }}
                        </div>
                        <h3 class="mt-5 font-serif text-xl font-semibold">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-400">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="jalur" class="relative bg-paper">
        <div class="mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28">
            <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Jalur Pendaftaran</p>
                    <h2 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                        Empat jalur, satu tujuan
                    </h2>
                </div>
            </div>

            @php
            $jalur = [
                ['name' => 'Reguler', 'desc' => 'Jalur seleksi standar berbasis nilai akademik dan tes potensi.', 'svg' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['name' => 'Prestasi', 'desc' => 'Untuk siswa berprestasi akademik atau non-akademik di tingkat nasional.', 'svg' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                ['name' => 'Beasiswa', 'desc' => 'Pembiayaan penuh untuk calon mahasiswa terpilih dengan kriteria khusus.', 'svg' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['name' => 'Transfer', 'desc' => 'Untuk mahasiswa pindahan dari perguruan tinggi lain.', 'svg' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
            ];
            @endphp

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($jalur as $j)
                    <div class="rounded-lg border border-ink-200 bg-white p-6 shadow-soft transition hover:-translate-y-0.5 hover:shadow-card">
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-ink-200 bg-ink-50 text-ink-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $j['svg'] }}"/></svg>
                        </div>
                        <h3 class="mt-5 font-serif text-xl font-semibold text-ink-900">{{ $j['name'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-500">{{ $j['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="faq" class="relative bg-paper">
        <div class="mx-auto max-w-3xl px-4 py-20 sm:px-6 sm:py-28">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">FAQ</p>
            <h2 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                Pertanyaan umum
            </h2>

            @php
            $faqs = [
                ['q' => 'Bagaimana cara mendaftar?', 'a' => 'Klik tombol Daftar di halaman ini, isi form pendaftaran online sampai selesai, dan Anda akan menerima nomor pendaftaran secara otomatis. Tidak perlu datang ke kampus untuk pendaftaran awal.'],
                ['q' => 'Berapa biaya pendaftaran?', 'a' => 'Pendaftaran online tidak dipungut biaya. Biaya hanya dikenakan saat tahap tes seleksi sesuai jalur yang dipilih.'],
                ['q' => 'Kapan pengumuman seleksi?', 'a' => 'Hasil seleksi diumumkan paling lambat 14 hari setelah Anda mengikuti tes. Pengumuman dikirim via email dan dapat dicek di portal pendaftar.'],
                ['q' => 'Dokumen apa saja yang dibutuhkan?', 'a' => 'Pas foto, KTP/Kartu Pelajar, ijazah/SKL, transkrip nilai rapor, dan surat keterangan tambahan sesuai jalur (prestasi/beasiswa).'],
                ['q' => 'Apakah bisa pindah jalur setelah daftar?', 'a' => 'Bisa, dengan menghubungi tim admin maksimal 7 hari setelah pendaftaran. Setelah itu pilihan jalur tidak dapat diubah.'],
            ];
            @endphp

            <div class="mt-12 divide-y divide-ink-200 border-y border-ink-200">
                @foreach($faqs as $faq)
                    <details class="group py-5">
                        <summary class="flex cursor-pointer items-center justify-between gap-6 list-none">
                            <h3 class="font-serif text-lg font-semibold text-ink-900">{{ $faq['q'] }}</h3>
                            <span class="flex-shrink-0 text-ink-400 transition group-open:rotate-45">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-ink-500">{{ $faq['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative bg-ink-900 text-paper">
        <div class="absolute inset-x-0 top-0 h-px gold-line"></div>
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20">
            <div class="flex flex-col items-start justify-between gap-8 lg:flex-row lg:items-center">
                <div class="max-w-xl">
                    <h2 class="font-serif text-3xl font-semibold tracking-tight sm:text-4xl">
                        Mulai langkah pertama Anda hari ini.
                    </h2>
                    <p class="mt-3 text-sm leading-relaxed text-ink-300">
                        Kuota terbatas. Pendaftaran ditutup setelah kuota terpenuhi.
                    </p>
                </div>
                <a href="{{ route('daftar') }}" class="group inline-flex items-center gap-2 rounded-md bg-gold-600 px-7 py-4 text-sm font-semibold text-ink-950 shadow-lift transition hover:bg-gold-500">
                    Daftar Sekarang
                    <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>
