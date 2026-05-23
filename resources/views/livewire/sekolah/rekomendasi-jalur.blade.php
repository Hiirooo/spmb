<div>
    @if(! $showResult)
        @if($sekolah->latitude && $sekolah->longitude)
            <div class="mb-6 rounded-lg border border-gold-200 bg-gold-50/40 p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-700">Otomatis Hitung Jarak</p>
                <p class="mt-2 text-sm text-ink-700">
                    Masukkan alamat Anda, atau tempel koordinat dari Google Maps untuk akurasi maksimum.
                </p>
                <div class="mt-3 flex flex-col gap-2 sm:flex-row">
                    <input type="text" wire:model="alamatLengkap" placeholder="Jl. Sudirman, Palembang  —  atau  —  -3.009556, 104.818746"
                        class="flex-1 rounded-lg border-ink-200 bg-white px-3 py-2 text-sm placeholder:text-ink-400 focus:border-ink-900 focus:shadow-[0_0_0_3px_rgba(184,134,11,0.15)] focus:ring-0" />
                    <button type="button" wire:click="cekJarak" wire:loading.attr="disabled" wire:target="cekJarak"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-ink-900 px-4 py-2 text-sm font-semibold text-paper hover:bg-ink-800 disabled:opacity-50">
                        <svg wire:loading wire:target="cekJarak" class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Cek Jarak
                    </button>
                </div>
                <p class="mt-2 text-[11px] text-ink-500">
                    Tip: Buka Google Maps → klik kanan di lokasi rumah → klik koordinat yang muncul untuk menyalin (format <code class="rounded bg-ink-100 px-1">-3.009556, 104.818746</code>).
                </p>
                @if($jarakKm !== null)
                    <div class="mt-3 rounded-md bg-emerald-50 px-3 py-2 text-xs text-emerald-700">
                        <strong>Jarak:</strong> {{ $jarakKm }} km dari {{ $sekolah->nama }}
                        @if($alamatHasilGeocode) · <span class="text-emerald-600/70">{{ $alamatHasilGeocode }}</span> @endif
                        · pertanyaan jarak (#5) terisi otomatis ✓
                    </div>
                @elseif($cekJarakError)
                    <div class="mt-3 rounded-md bg-rose-50 px-3 py-2 text-xs text-rose-700">{{ $cekJarakError }}</div>
                @endif
            </div>
        @endif

        <form wire:submit="submit" class="space-y-6">
            @foreach($questions as $key => $q)
                <div class="rounded-lg border border-ink-200 bg-white p-6 shadow-soft">
                    <p class="font-serif text-base font-semibold text-ink-900">
                        {{ $loop->iteration }}. {{ $q['label'] }}
                        @if($key === 'jarak_sekolah' && $jarakKm !== null)
                            <span class="ml-2 inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-medium text-emerald-700">Auto: {{ $jarakKm }} km</span>
                        @endif
                    </p>
                    <div class="mt-4 grid gap-2 sm:grid-cols-2">
                        @foreach($q['options'] as $value => $label)
                            <label class="relative flex cursor-pointer items-start gap-3 rounded-md border border-ink-200 px-4 py-3 text-sm hover:bg-paper has-[:checked]:border-ink-900 has-[:checked]:bg-ink-900/5">
                                <input
                                    type="radio"
                                    wire:model="answers.{{ $key }}"
                                    value="{{ $value }}"
                                    class="mt-0.5 h-4 w-4 border-ink-300 text-ink-900 focus:ring-ink-900"
                                />
                                <span class="text-ink-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error("answers.{$key}")
                        <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            <div class="flex justify-end gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-md bg-ink-900 px-6 py-3 text-sm font-semibold text-paper shadow-soft hover:bg-ink-800 disabled:opacity-50"
                    wire:loading.attr="disabled"
                    wire:target="submit">
                    <svg wire:loading wire:target="submit" class="-ml-1 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    Lihat Rekomendasi
                    <svg wire:loading.remove wire:target="submit" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </button>
            </div>
        </form>
    @else
        @php
            $colorMap = [
                'afirmasi' => ['bg-emerald-50', 'text-emerald-700', 'ring-emerald-200', 'bg-emerald-500'],
                'domisili' => ['bg-ink-100', 'text-ink-700', 'ring-ink-200', 'bg-ink-700'],
                'mutasi' => ['bg-amber-50', 'text-amber-700', 'ring-amber-200', 'bg-amber-500'],
                'prestasi' => ['bg-sky-50', 'text-sky-700', 'ring-sky-200', 'bg-sky-500'],
            ];
            $jalurLabel = \App\Support\SpmbDokumen::JALUR;
            $top = array_key_first($this->result);
        @endphp

        <div class="space-y-6">
            <div class="rounded-lg border-2 border-ink-900 bg-white p-8 shadow-card">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-600">Rekomendasi Utama</p>
                <h3 class="mt-3 font-serif text-3xl font-semibold text-ink-900 sm:text-4xl">
                    Jalur {{ $jalurLabel[$top] }}
                </h3>
                <p class="mt-2 text-sm text-ink-500">
                    Berdasarkan jawaban Anda, jalur {{ strtolower($jalurLabel[$top]) }} memiliki kecocokan tertinggi.
                </p>
                <ul class="mt-4 space-y-1.5">
                    @foreach($this->result[$top]['reasons'] as $reason)
                        <li class="flex items-start gap-2 text-sm text-ink-700">
                            <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ $reason }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-6 flex flex-wrap gap-3">
                    <button wire:click="lanjutkanPendaftaran('{{ $top }}')" class="inline-flex items-center gap-2 rounded-md bg-ink-900 px-5 py-2.5 text-sm font-semibold text-paper hover:bg-ink-800">
                        Lanjut ke Pendaftaran
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                    <button wire:click="ulangi" type="button" class="inline-flex items-center gap-2 rounded-md border border-ink-300 bg-white px-5 py-2.5 text-sm text-ink-700 hover:bg-paper">Ulang Penilaian</button>
                </div>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-ink-500">Skor Semua Jalur</p>
                <div class="mt-4 grid gap-3">
                    @foreach($this->result as $jalur => $data)
                        @php $color = $colorMap[$jalur] ?? $colorMap['domisili']; @endphp
                        <div class="rounded-lg border border-ink-200 bg-white p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-serif text-lg font-semibold text-ink-900">{{ $jalurLabel[$jalur] }}</h4>
                                        @if($data['eligible'])
                                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold ring-1 {{ $color[0] }} {{ $color[1] }} {{ $color[2] }}">Memenuhi syarat</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-ink-50 px-2 py-0.5 text-[10px] font-semibold text-ink-500 ring-1 ring-ink-200">Belum memenuhi</span>
                                        @endif
                                    </div>
                                    @if(count($data['reasons']))
                                        <ul class="mt-2 space-y-1 text-xs text-ink-500">
                                            @foreach($data['reasons'] as $r)
                                                <li>· {{ $r }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="font-mono text-2xl font-semibold text-ink-900">{{ $data['percent'] }}%</p>
                                    <p class="text-xs text-ink-500">kecocokan</p>
                                </div>
                            </div>
                            <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-ink-100">
                                <div class="h-full {{ $color[3] }}" style="width: {{ $data['percent'] }}%"></div>
                            </div>
                            @if($jalur !== $top && $data['eligible'])
                                <div class="mt-3">
                                    <button wire:click="lanjutkanPendaftaran('{{ $jalur }}')" type="button" class="text-xs font-medium text-ink-700 underline-offset-4 hover:underline">Pilih jalur ini &rarr;</button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
