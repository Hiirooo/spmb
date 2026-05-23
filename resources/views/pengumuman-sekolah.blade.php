<x-layouts.public :title="'Pengumuman ' . $sekolah->nama">
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 sm:py-16">
        <nav class="flex items-center gap-2 text-xs text-ink-500">
            <a href="{{ route('pengumuman.index') }}" class="hover:text-ink-900">Pengumuman</a>
            <span class="text-ink-300">/</span>
            <span class="text-ink-700">{{ $sekolah->nama }}</span>
        </nav>

        <div class="mt-6">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Pengumuman Hasil Seleksi</p>
            <h1 class="mt-3 font-serif text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
                {{ $sekolah->nama }}
            </h1>
            <p class="mt-3 text-sm text-ink-500">{{ $sekolah->kabupaten_kota }} · NPSN {{ $sekolah->npsn }}</p>
        </div>

        @php
        $jalurOpts = \App\Support\SpmbDokumen::JALUR;
        $jalurColors = ['afirmasi' => 'emerald', 'domisili' => 'gray', 'mutasi' => 'amber', 'prestasi' => 'sky'];
        @endphp

        <div class="mt-8 grid gap-4 sm:grid-cols-4">
            @foreach($jalurOpts as $key => $label)
                @php $count = $countPerJalur[$key] ?? 0; @endphp
                <a href="{{ route('pengumuman.sekolah', ['sekolah' => $sekolah->slug, 'jalur' => $jalurFilter === $key ? null : $key]) }}" class="rounded-lg border bg-white p-4 transition hover:-translate-y-0.5 hover:shadow-card {{ $jalurFilter === $key ? 'border-ink-900 shadow-soft' : 'border-ink-200' }}">
                    <p class="text-xs font-medium uppercase tracking-wide text-ink-500">{{ $label }}</p>
                    <p class="mt-2 font-mono text-2xl font-semibold text-ink-900">{{ $count }}</p>
                    <p class="text-xs text-ink-500">diterima</p>
                </a>
            @endforeach
        </div>

        <form method="GET" class="mt-8 flex flex-wrap gap-3">
            <input type="hidden" name="jalur" value="{{ $jalurFilter }}">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama / nomor / NISN..." class="flex-1 min-w-[200px] rounded-md border-ink-300 bg-white px-4 py-2.5 text-sm placeholder:text-ink-400 focus:border-ink-900 focus:ring-ink-900" />
            <button type="submit" class="rounded-md bg-ink-900 px-5 py-2.5 text-sm font-semibold text-paper hover:bg-ink-800">Cari</button>
            @if($q || $jalurFilter)
                <a href="{{ route('pengumuman.sekolah', ['sekolah' => $sekolah->slug]) }}" class="rounded-md border border-ink-300 bg-white px-5 py-2.5 text-sm font-medium text-ink-700 hover:bg-paper">Reset</a>
            @endif
        </form>

        <div class="mt-8 overflow-hidden rounded-lg border border-ink-200 bg-white shadow-soft">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead class="bg-paper">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">No. Pendaftaran</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">Jalur</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse($pendaftars as $p)
                        <tr>
                            <td class="px-4 py-3 text-ink-500">{{ $loop->iteration + ($pendaftars->currentPage() - 1) * $pendaftars->perPage() }}</td>
                            <td class="px-4 py-3 font-mono text-xs font-semibold text-ink-900">{{ $p->nomor_pendaftaran }}</td>
                            <td class="px-4 py-3 font-medium text-ink-900">{{ $p->nama_lengkap }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full bg-{{ $jalurColors[$p->jalur_pendaftaran] ?? 'gray' }}-50 px-2 py-0.5 text-[10px] font-semibold text-{{ $jalurColors[$p->jalur_pendaftaran] ?? 'gray' }}-700 ring-1 ring-{{ $jalurColors[$p->jalur_pendaftaran] ?? 'gray' }}-200">
                                    {{ ucfirst($p->jalur_pendaftaran) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-sm text-ink-500">
                                @if($q || $jalurFilter)
                                    Tidak ada hasil sesuai filter. <a href="{{ route('pengumuman.sekolah', ['sekolah' => $sekolah->slug]) }}" class="font-medium text-ink-900 underline">Reset</a>.
                                @else
                                    Belum ada pengumuman murid diterima untuk sekolah ini.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $pendaftars->links() }}</div>

        <p class="mt-8 text-xs text-ink-500 text-center">
            Pengumuman bersifat publik untuk keperluan transparansi seleksi sesuai Juknis Disdik Sumsel.
        </p>
    </div>
</x-layouts.public>
