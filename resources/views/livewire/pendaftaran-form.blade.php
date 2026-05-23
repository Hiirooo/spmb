<div>
    @php
        $inputBase = 'w-full rounded-lg border bg-white px-3.5 py-2.5 text-[15px] text-ink-900 shadow-soft transition placeholder:text-ink-400 focus:outline-none focus:border-ink-900 focus:shadow-[0_0_0_3px_rgba(184,134,11,0.15)]';
        $err = fn ($key) => $errors->has($key) ? 'border-rose-400' : 'border-ink-200 hover:border-ink-300';
    @endphp

    <form wire:submit="submit" class="space-y-8">

        {{-- ============ SECTION 1: IDENTITAS ============ --}}
        <x-spmb.section number="1" title="Identitas Calon Murid" description="Data pribadi sesuai Kartu Keluarga & Akta Kelahiran.">
            <x-spmb.field name="nama_lengkap" label="Nama Lengkap" required span="2">
                <input type="text" id="field-nama_lengkap" wire:model.blur="nama_lengkap" placeholder="Sesuai akta kelahiran"
                    class="{{ $inputBase }} {{ $err('nama_lengkap') }}" />
            </x-spmb.field>

            <x-spmb.field name="nisn" label="NISN" required hint="10 digit dari sekolah asal.">
                <input type="text" inputmode="numeric" id="field-nisn" wire:model.blur="nisn" maxlength="10" placeholder="0012345678"
                    class="{{ $inputBase }} {{ $err('nisn') }} font-mono tracking-wide" />
            </x-spmb.field>

            <x-spmb.field name="nik" label="NIK" required hint="16 digit sesuai Kartu Keluarga.">
                <input type="text" inputmode="numeric" id="field-nik" wire:model.blur="nik" maxlength="16" placeholder="1671234567890123"
                    class="{{ $inputBase }} {{ $err('nik') }} font-mono tracking-wide" />
            </x-spmb.field>

            {{-- Jenis Kelamin: pill segmented --}}
            <x-spmb.field name="jenis_kelamin" label="Jenis Kelamin" required>
                <div class="grid grid-cols-2 gap-2">
                    @foreach([['L', 'Laki-laki', 'M9 12l2 2 4-4'], ['P', 'Perempuan', 'M9 12l2 2 4-4']] as [$val, $label, $svg])
                        <button type="button" wire:click="$set('jenis_kelamin', '{{ $val }}')"
                            @class([
                                'group flex items-center justify-center gap-2 rounded-lg border px-4 py-2.5 text-sm font-medium transition',
                                'border-ink-900 bg-ink-900 text-paper shadow-soft' => $jenis_kelamin === $val,
                                'border-ink-200 bg-white text-ink-700 hover:border-ink-400 hover:bg-paper' => $jenis_kelamin !== $val,
                            ])
                        >
                            @if($jenis_kelamin === $val)
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            @endif
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </x-spmb.field>

            <x-spmb.field name="tempat_lahir" label="Tempat Lahir" required>
                <input type="text" id="field-tempat_lahir" wire:model.blur="tempat_lahir" placeholder="Kota tempat lahir"
                    class="{{ $inputBase }} {{ $err('tempat_lahir') }}" />
            </x-spmb.field>

            <x-spmb.field name="tanggal_lahir" label="Tanggal Lahir" required>
                <input type="date" id="field-tanggal_lahir" wire:model.blur="tanggal_lahir"
                    max="{{ now()->subYears(12)->format('Y-m-d') }}"
                    min="2000-01-01"
                    class="{{ $inputBase }} {{ $err('tanggal_lahir') }}" />
            </x-spmb.field>

            <x-spmb.field name="alamat" label="Alamat Lengkap (sesuai KK)" required span="2">
                <textarea id="field-alamat" wire:model.blur="alamat" rows="3" placeholder="Jalan, RT/RW, kelurahan, kecamatan, kota, provinsi, kode pos"
                    class="{{ $inputBase }} {{ $err('alamat') }} resize-none leading-relaxed"></textarea>
            </x-spmb.field>
        </x-spmb.section>

        {{-- ============ SECTION 2: ORANG TUA ============ --}}
        <x-spmb.section number="2" title="Data Orang Tua / Wali" description="Untuk verifikasi data ekonomi (terutama jalur Afirmasi).">
            <x-spmb.field name="nama_ayah" label="Nama Ayah" required>
                <input type="text" id="field-nama_ayah" wire:model.blur="nama_ayah"
                    class="{{ $inputBase }} {{ $err('nama_ayah') }}" />
            </x-spmb.field>

            <x-spmb.field name="nama_ibu" label="Nama Ibu" required>
                <input type="text" id="field-nama_ibu" wire:model.blur="nama_ibu"
                    class="{{ $inputBase }} {{ $err('nama_ibu') }}" />
            </x-spmb.field>

            <x-spmb.field name="pekerjaan_ortu" label="Pekerjaan Orang Tua / Wali" required>
                <input type="text" id="field-pekerjaan_ortu" wire:model.blur="pekerjaan_ortu" placeholder="Mis: Wiraswasta, PNS, Petani"
                    class="{{ $inputBase }} {{ $err('pekerjaan_ortu') }}" />
            </x-spmb.field>

            <x-spmb.select
                name="penghasilan_ortu"
                label="Penghasilan Bulanan Orang Tua"
                :required="true"
                placeholder="Pilih rentang penghasilan"
                :options="[
                    ['value' => '< 1 juta', 'label' => 'Kurang dari Rp 1.000.000'],
                    ['value' => '1-3 juta', 'label' => 'Rp 1.000.000 – Rp 3.000.000'],
                    ['value' => '3-5 juta', 'label' => 'Rp 3.000.000 – Rp 5.000.000'],
                    ['value' => '5-10 juta', 'label' => 'Rp 5.000.000 – Rp 10.000.000'],
                    ['value' => '> 10 juta', 'label' => 'Lebih dari Rp 10.000.000'],
                ]"
            />
        </x-spmb.section>

        {{-- ============ SECTION 3: KONTAK ============ --}}
        <x-spmb.section number="3" title="Kontak Aktif" description="Pastikan email & WhatsApp aktif — pengumuman dikirim ke sini.">
            <x-spmb.field name="email" label="Email" required>
                <input type="email" id="field-email" wire:model.blur="email" placeholder="nama@contoh.com"
                    class="{{ $inputBase }} {{ $err('email') }}" />
            </x-spmb.field>

            <x-spmb.field name="no_telepon" label="Nomor WhatsApp" required hint="Format: 0812xxxxxxxx">
                <input type="tel" id="field-no_telepon" wire:model.blur="no_telepon" maxlength="20" placeholder="081234567890"
                    class="{{ $inputBase }} {{ $err('no_telepon') }} font-mono" />
            </x-spmb.field>
        </x-spmb.section>

        {{-- ============ SECTION 4: SEKOLAH ASAL ============ --}}
        <x-spmb.section number="4" title="Asal Sekolah">
            <x-spmb.field name="asal_sekolah" label="Asal SMP / Sederajat" required span="2">
                <input type="text" id="field-asal_sekolah" wire:model.blur="asal_sekolah" placeholder="Mis: SMP Negeri 1 Palembang"
                    class="{{ $inputBase }} {{ $err('asal_sekolah') }}" />
            </x-spmb.field>

            <x-spmb.field name="tahun_lulus" label="Tahun Lulus" required>
                <input type="number" id="field-tahun_lulus" wire:model.blur="tahun_lulus"
                    min="2020" max="{{ now()->format('Y') }}"
                    class="{{ $inputBase }} {{ $err('tahun_lulus') }} font-mono" />
            </x-spmb.field>
        </x-spmb.section>

        {{-- ============ SECTION 5: PILIHAN ============ --}}
        <x-spmb.section number="5" title="Pilihan Pendaftaran" description="Sesuai Juknis SPMB SMA Negeri Provinsi Sumsel TA {{ date('Y') }}/{{ date('Y') + 1 }}.">

            {{-- Sekolah tujuan: read-only display --}}
            <x-spmb.field name="_sekolah_tujuan" label="Sekolah Tujuan">
                <div class="flex items-center gap-2 rounded-lg border border-ink-200 bg-paper px-3.5 py-2.5 text-[15px]">
                    <svg class="h-4 w-4 flex-shrink-0 text-gold-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="font-medium text-ink-900">{{ $sekolah->nama }}</span>
                </div>
            </x-spmb.field>

            {{-- Jalur: as cards --}}
            <div class="sm:col-span-2">
                <p class="text-sm font-semibold text-ink-800">
                    Jalur Pendaftaran <span class="ml-0.5 text-gold-600">*</span>
                </p>
                <p class="mt-0.5 text-xs text-ink-500">Pilih satu jalur. Yang kuotanya penuh tidak dapat dipilih.</p>

                <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($this->jalurOptions as $opt)
                        @php
                            $isSelected = $jalur_pendaftaran === $opt['value'];
                            $isDisabled = $opt['penuh'];
                        @endphp
                        <button
                            type="button"
                            @if(! $isDisabled) wire:click="$set('jalur_pendaftaran', '{{ $opt['value'] }}')" @endif
                            @disabled($isDisabled)
                            @class([
                                'relative flex flex-col items-start gap-1 rounded-lg border p-3.5 text-left transition',
                                'border-ink-900 bg-ink-900 text-paper shadow-card' => $isSelected,
                                'border-ink-200 bg-white text-ink-800 hover:border-ink-400 hover:bg-paper hover:-translate-y-0.5 hover:shadow-soft' => ! $isSelected && ! $isDisabled,
                                'border-ink-200 bg-ink-50/50 text-ink-400 cursor-not-allowed' => $isDisabled,
                            ])
                        >
                            @if($isSelected)
                                <span class="absolute right-2.5 top-2.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-gold-500 text-ink-950">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </span>
                            @endif
                            @if($isDisabled)
                                <span class="absolute right-2.5 top-2.5 inline-flex items-center rounded-full bg-rose-100 px-1.5 py-0.5 text-[9px] font-semibold uppercase tracking-wide text-rose-700">Penuh</span>
                            @endif

                            <span @class([
                                'font-serif text-base font-semibold',
                                'text-paper' => $isSelected,
                            ])>{{ $opt['label'] }}</span>
                            <span @class([
                                'text-[11px]',
                                'text-paper/70' => $isSelected,
                                'text-ink-500' => ! $isSelected && ! $isDisabled,
                            ])>
                                @switch($opt['value'])
                                    @case('afirmasi') Keluarga tidak mampu / disabilitas @break
                                    @case('domisili') Domisili dekat sekolah @break
                                    @case('mutasi') Mutasi tugas ortu / anak guru @break
                                    @case('prestasi') Akademik / non-akademik / TKA @break
                                @endswitch
                            </span>
                        </button>
                    @endforeach
                </div>

                @error('jalur_pendaftaran')
                    <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Conditional: Kategori Prestasi --}}
            @if($jalur_pendaftaran === 'prestasi')
                <x-spmb.select
                    name="kategori_prestasi"
                    label="Kategori Prestasi"
                    :required="true"
                    placeholder="Pilih kategori"
                    :options="collect(\App\Support\SpmbDokumen::KATEGORI_PRESTASI)->map(fn($l, $v) => ['value' => $v, 'label' => $l])->values()->all()"
                    span="2"
                />
            @endif

            {{-- Conditional: Tingkat Prestasi (only if kategori non-akademik) --}}
            @if($jalur_pendaftaran === 'prestasi' && $kategori_prestasi === 'non_akademik')
                <x-spmb.select
                    name="tingkat_prestasi"
                    label="Tingkat Prestasi"
                    :required="true"
                    placeholder="Pilih tingkat"
                    :options="collect(\App\Support\SpmbDokumen::TINGKAT_PRESTASI)->map(fn($l, $v) => ['value' => $v, 'label' => $l])->values()->all()"
                    span="2"
                />
            @endif
        </x-spmb.section>

        {{-- ============ SUBMIT ============ --}}
        <div class="flex flex-col-reverse items-stretch gap-3 border-t border-ink-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-xs text-ink-500">
                Pastikan seluruh data sudah benar. Anda hanya boleh mendaftar di satu sekolah dan satu jalur.
            </p>
            <button type="submit"
                wire:loading.attr="disabled"
                wire:target="submit"
                class="group inline-flex items-center justify-center gap-2 rounded-lg bg-ink-900 px-7 py-3 text-sm font-semibold text-paper shadow-soft transition hover:bg-ink-800 focus:outline-none focus:shadow-[0_0_0_3px_rgba(184,134,11,0.25)] disabled:opacity-60 disabled:cursor-not-allowed"
            >
                <svg wire:loading wire:target="submit" class="-ml-1 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span>Kirim Pendaftaran</span>
                <svg wire:loading.remove wire:target="submit" class="h-3.5 w-3.5 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </button>
        </div>

        @if($errors->any())
            <div class="rounded-lg border border-rose-200 bg-rose-50 p-4">
                <p class="text-sm font-semibold text-rose-800">⚠ Terdapat {{ $errors->count() }} kesalahan pengisian. Periksa kembali kolom yang ditandai merah.</p>
            </div>
        @endif
    </form>
</div>
