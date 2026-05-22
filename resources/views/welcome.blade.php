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
                    Platform SPMB<br>
                    <span class="italic text-gold-500">SMA Negeri Sumsel</span><br>
                    untuk Sekolah & Siswa
                </h1>

                <p class="mt-8 max-w-xl text-lg leading-relaxed text-ink-300">
                    Sekolah kelola pendaftaran, kuota, dan verifikasi dokumen.
                    Siswa cek rekomendasi jalur, daftar online, dan unggah berkas
                    sesuai Juknis Disdik Sumsel TA 2026/2027.
                </p>

                <div class="mt-10 flex flex-wrap items-center gap-4">
                    @auth
                        <a href="{{ route('sekolah.index') }}" class="group inline-flex items-center gap-2 rounded-md bg-gold-600 px-6 py-3.5 text-sm font-semibold text-ink-950 shadow-soft transition hover:bg-gold-500">
                            Pilih Sekolah
                            <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="group inline-flex items-center gap-2 rounded-md bg-gold-600 px-6 py-3.5 text-sm font-semibold text-ink-950 shadow-soft transition hover:bg-gold-500">
                            Saya Calon Siswa
                            <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('sekolah.register') }}" class="inline-flex items-center gap-2 rounded-md border border-ink-700 bg-ink-800/40 px-6 py-3.5 text-sm font-medium text-paper transition hover:bg-ink-800">
                            Saya Pihak Sekolah
                        </a>
                    @endauth
                </div>
            </div>

            <div class="mt-20 grid grid-cols-2 gap-px overflow-hidden rounded-lg bg-ink-700 lg:grid-cols-4">
                @php
                $heroStats = [
                    ['label' => 'Sekolah Terdaftar', 'value' => $totalSekolah, 'desc' => 'aktif menerima'],
                    ['label' => 'Total Pendaftar', 'value' => $totalPendaftar, 'desc' => 'pendaftaran masuk'],
                    ['label' => 'Telah Diterima', 'value' => $diterima, 'desc' => 'lulus seleksi'],
                    ['label' => 'Sedang Verifikasi', 'value' => $verifikasi, 'desc' => 'dalam proses'],
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
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Sekolah Terdaftar</p>
                    <h2 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                        SMA Negeri se-Sumatera Selatan
                    </h2>
                </div>
                <a href="{{ route('sekolah.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-ink-700 hover:text-ink-900">
                    Lihat Semua Sekolah
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="mt-16 grid gap-px overflow-hidden rounded-lg bg-ink-200 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($sekolahPreview as $s)
                    <a href="{{ route('sekolah.show', ['sekolah' => $s->slug]) }}" class="group relative bg-paper p-6 transition hover:bg-white">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-gold-600">{{ $s->kabupaten_kota }}</p>
                        <h3 class="mt-4 font-serif text-lg font-semibold text-ink-900">{{ $s->nama }}</h3>
                        @if($s->deskripsi)
                            <p class="mt-2 text-xs leading-relaxed text-ink-500 line-clamp-2">{{ $s->deskripsi }}</p>
                        @endif
                        <div class="mt-4 flex items-center justify-between text-xs">
                            <span class="text-ink-500">{{ number_format($s->daya_tampung_total) }} kuota</span>
                            <span class="font-medium text-ink-700 group-hover:translate-x-0.5 transition inline-flex items-center gap-1">
                                Detail
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="bg-paper p-8 text-center text-sm text-ink-500 sm:col-span-2 lg:col-span-3">
                        Belum ada sekolah aktif. <a href="{{ route('sekolah.register') }}" class="font-medium text-ink-900 underline">Daftarkan sekolah pertama</a>.
                    </div>
                @endforelse
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
                ['num' => '01', 'title' => 'Buat Akun', 'desc' => 'Daftarkan akun dengan email aktif dan password yang aman.'],
                ['num' => '02', 'title' => 'Isi Data Diri', 'desc' => 'Lengkapi NISN, NIK, data orang tua, dan asal sekolah.'],
                ['num' => '03', 'title' => 'Unggah Berkas', 'desc' => 'Upload dokumen sesuai jalur (KK, rapor, SKL, dll). Maks 2 MB.'],
                ['num' => '04', 'title' => 'Verifikasi', 'desc' => 'Tim panitia memvalidasi berkas dalam 1–3 hari kerja.'],
                ['num' => '05', 'title' => 'Pengumuman', 'desc' => 'Hasil seleksi dikirim via email dan portal pendaftar.'],
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
                ['name' => 'Afirmasi', 'desc' => 'Untuk keluarga ekonomi tidak mampu (KIP/KKS/PKH) atau penyandang disabilitas. Min 30% kuota.', 'svg' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['name' => 'Domisili', 'desc' => 'Bagi calon murid berdomisili di wilayah penerimaan. Penilaian: jarak + nilai rapor. Min 30% kuota.', 'svg' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['name' => 'Mutasi', 'desc' => 'Perpindahan tugas orang tua/wali (TNI, Polri, ASN) atau anak guru. Maks 5% kuota.', 'svg' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                ['name' => 'Prestasi', 'desc' => 'Akademik (rapor + TKA), non-akademik, atau nilai TKA. Min 35% kuota.', 'svg' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
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
                ['q' => 'Apa saja jalur pendaftaran SPMB SMA Negeri Sumsel?', 'a' => 'Empat jalur: Afirmasi (keluarga tidak mampu/disabilitas), Domisili (wilayah + nilai rapor), Mutasi (perpindahan tugas ortu/anak guru), dan Prestasi (akademik/non-akademik/TKA). Setiap calon murid hanya boleh memilih satu jalur.'],
                ['q' => 'Berapa biaya pendaftaran?', 'a' => 'Pendaftaran online tidak dipungut biaya sesuai Juknis SPMB Sumsel. Daftar ulang setelah dinyatakan diterima dilakukan langsung di sekolah tujuan.'],
                ['q' => 'Dokumen apa saja yang dibutuhkan?', 'a' => 'Wajib untuk semua jalur: KK, akta kelahiran, ijazah/SKL, rapor 5 semester, pas foto, dan pakta integritas. Dokumen tambahan tergantung jalur — misalnya KIP/KKS/PKH untuk afirmasi, surat domisili untuk jalur domisili, sertifikat prestasi untuk jalur prestasi.'],
                ['q' => 'Format dan ukuran file dokumen?', 'a' => 'Format yang diterima: PDF, JPG, atau PNG. Ukuran maksimal 2 MB per file. Pastikan dokumen jelas terbaca dan sesuai aslinya.'],
                ['q' => 'Apakah jalur prestasi wajib mengikuti TKA?', 'a' => 'Ya, sesuai aturan baru SPMB Sumsel 2026/2027, calon murid jalur prestasi akademik wajib menyertakan hasil Tes Kemampuan Akademik (TKA) sebagai komponen penilaian.'],
                ['q' => 'Kapan pengumuman seleksi?', 'a' => 'Jadwal mengikuti Surat Edaran Disdik Sumsel 2026/2027. Pengumuman jalur Afirmasi, Domisili, Mutasi, dan Prestasi pada awal Juni; Pengumuman tes akademik pada akhir Juni. Pengumuman dikirim via email dan dapat dicek di portal pendaftar.'],
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
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="rounded-lg border border-ink-700 bg-ink-800/40 p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-400">Untuk Calon Siswa</p>
                    <h3 class="mt-3 font-serif text-2xl font-semibold sm:text-3xl">
                        Cari sekolah, cek jalur,<br>daftar online.
                    </h3>
                    <p class="mt-3 text-sm text-ink-300">
                        Asesmen 10 pertanyaan untuk rekomendasi jalur paling cocok berdasarkan profil Anda.
                    </p>
                    <a href="{{ route('sekolah.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-md bg-gold-600 px-5 py-3 text-sm font-semibold text-ink-950 hover:bg-gold-500">
                        Pilih Sekolah Tujuan
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="rounded-lg border border-ink-700 bg-ink-800/40 p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-400">Untuk Pihak Sekolah</p>
                    <h3 class="mt-3 font-serif text-2xl font-semibold sm:text-3xl">
                        Kelola pendaftaran<br>tanpa biaya.
                    </h3>
                    <p class="mt-3 text-sm text-ink-300">
                        Dashboard admin, verifikasi dokumen, kuota per jalur, dan statistik pendaftar real-time.
                    </p>
                    <a href="{{ route('sekolah.register') }}" class="mt-6 inline-flex items-center gap-2 rounded-md border border-paper bg-transparent px-5 py-3 text-sm font-semibold text-paper hover:bg-paper hover:text-ink-900 transition">
                        Daftarkan Sekolah
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
