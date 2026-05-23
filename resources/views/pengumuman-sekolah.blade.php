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
            <div class="relative flex-1 min-w-[200px]">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-ink-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                </span>
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama, nomor pendaftaran, atau NISN..."
                    class="w-full rounded-lg border-ink-200 bg-white py-2.5 pl-10 pr-4 text-sm text-ink-900 shadow-soft placeholder:text-ink-400 focus:border-ink-900 focus:shadow-[0_0_0_3px_rgba(184,134,11,0.15)] focus:ring-0" />
            </div>
            <button type="submit" class="rounded-lg bg-ink-900 px-6 py-2.5 text-sm font-semibold text-paper shadow-soft hover:bg-ink-800 transition">Cari</button>
            @if($q || $jalurFilter)
                <a href="{{ route('pengumuman.sekolah', ['sekolah' => $sekolah->slug]) }}" class="rounded-lg border border-ink-200 bg-white px-5 py-2.5 text-sm font-medium text-ink-700 shadow-soft hover:bg-paper transition">Reset</a>
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
