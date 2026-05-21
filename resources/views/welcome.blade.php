<x-layouts.public title="SPMB - Penerimaan Mahasiswa Baru">
    <section class="text-center pt-8 pb-12 sm:pt-16">
        <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
            Pendaftaran {{ date('Y') }} Dibuka
        </span>
        <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-900 sm:text-6xl">
            Sistem Penerimaan <br class="hidden sm:block">
            <span class="text-amber-500">Mahasiswa Baru</span>
        </h1>
        <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-600">
            Daftar online dengan cepat, dapat nomor pendaftaran instan, pantau status verifikasi via email.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('daftar') }}" class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-amber-400">
                Mulai Pendaftaran
                <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
            <a href="#info" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-3 text-base font-semibold text-slate-700 hover:bg-slate-50">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </section>

    <section id="info" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mt-12">
        @php
        $stats = [
            ['label' => 'Total Pendaftar', 'value' => $totalPendaftar, 'color' => 'bg-blue-50 text-blue-600'],
            ['label' => 'Diterima', 'value' => $diterima, 'color' => 'bg-green-50 text-green-600'],
            ['label' => 'Sedang Diverifikasi', 'value' => $verifikasi, 'color' => 'bg-amber-50 text-amber-600'],
            ['label' => 'Program Studi', 'value' => 6, 'color' => 'bg-purple-50 text-purple-600'],
        ];
        @endphp
        @foreach($stats as $stat)
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <p class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ number_format($stat['value']) }}</p>
                <span class="mt-3 inline-flex rounded-full {{ $stat['color'] }} px-2 py-1 text-xs font-semibold">Live</span>
            </div>
        @endforeach
    </section>

    <section class="mt-16">
        <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Program Studi Tersedia</h2>
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach(['Teknik Informatika','Sistem Informasi','Manajemen','Akuntansi','Hukum','Psikologi'] as $prodi)
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200/60 hover:ring-amber-300 transition">
                    <h3 class="font-semibold text-slate-900">{{ $prodi }}</h3>
                    <p class="mt-1 text-sm text-slate-500">Tersedia untuk semua jalur pendaftaran</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-16">
        <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Jalur Pendaftaran</h2>
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach([
                ['name'=>'Reguler','desc'=>'Tes seleksi standar','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['name'=>'Prestasi','desc'=>'Bagi siswa berprestasi akademik/non-akademik','icon'=>'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                ['name'=>'Beasiswa','desc'=>'Pembiayaan penuh untuk yang lolos','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['name'=>'Transfer','desc'=>'Pindahan dari kampus lain','icon'=>'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
            ] as $jalur)
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200/60">
                    <div class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $jalur['icon'] }}"/></svg>
                    </div>
                    <h3 class="mt-3 font-semibold text-slate-900">{{ $jalur['name'] }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $jalur['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-16 rounded-2xl bg-amber-500 p-8 text-center text-white sm:p-12">
        <h2 class="text-2xl font-bold sm:text-3xl">Siap memulai perjalanan akademik Anda?</h2>
        <p class="mt-3 text-amber-50">Pendaftaran online cepat, gratis, dan dapat dipantau real-time.</p>
        <a href="{{ route('daftar') }}" class="mt-6 inline-flex items-center justify-center rounded-lg bg-white px-6 py-3 font-semibold text-amber-600 shadow-sm hover:bg-amber-50">
            Daftar Sekarang
        </a>
    </section>
</x-layouts.public>
