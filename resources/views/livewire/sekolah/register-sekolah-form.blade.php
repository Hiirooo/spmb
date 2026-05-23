<div>
    <form wire:submit="submit" class="space-y-8">

        <x-spmb.section number="1" title="Identitas Sekolah" description="Data resmi sekolah sesuai Dapodik.">
            <x-spmb.input
                name="npsn"
                label="NPSN"
                placeholder="8 digit"
                inputmode="numeric"
                maxlength="8"
                :required="true"
                mono
            />

            <x-spmb.select
                name="jenjang"
                label="Jenjang"
                :required="true"
                placeholder="Pilih jenjang"
                :options="$this->jenjangOptions()"
            />

            <x-spmb.input
                name="nama"
                label="Nama Sekolah"
                placeholder="Mis: SMA Negeri 1 Palembang"
                :required="true"
                span="2"
                maxlength="255"
            />

            <x-spmb.select
                name="status_negeri"
                label="Status"
                :required="true"
                placeholder="Pilih status"
                :options="$this->statusOptions()"
            />

            <x-spmb.select
                name="kabupaten_kota"
                label="Kabupaten/Kota"
                :required="true"
                placeholder="Pilih kabupaten/kota"
                :options="$this->kabupatenOptions()"
            />

            <x-spmb.textarea
                name="alamat"
                label="Alamat Lengkap"
                placeholder="Jalan, kelurahan, kecamatan"
                :rows="2"
                span="2"
            />

            <x-spmb.textarea
                name="deskripsi"
                label="Deskripsi Singkat"
                placeholder="Keunggulan & profil singkat sekolah"
                :rows="3"
                span="2"
            />
        </x-spmb.section>

        <x-spmb.section number="2" title="Kontak Sekolah">
            <x-spmb.input
                name="email_kontak"
                label="Email"
                type="email"
                placeholder="info@sekolah.sch.id"
                maxlength="255"
            />

            <x-spmb.input
                name="telepon_kontak"
                label="Telepon"
                type="tel"
                placeholder="0711-xxxxxxx"
                maxlength="25"
            />

            <x-spmb.input
                name="website"
                label="Website (opsional)"
                placeholder="https://sekolah.sch.id"
                span="2"
                maxlength="255"
            />

            <x-spmb.input
                name="daya_tampung_total"
                label="Daya Tampung Total"
                type="number"
                placeholder="Jumlah kursi tahun ini"
                hint="Total kursi yang tersedia tahun ajaran ini."
            />
        </x-spmb.section>

        <x-spmb.section number="3" title="Akun Admin Sekolah" description="Akun ini akan digunakan untuk mengelola pendaftar dan verifikasi dokumen.">
            <x-spmb.input
                name="admin_name"
                label="Nama Admin"
                placeholder="Nama lengkap penanggung jawab"
                :required="true"
                span="2"
                maxlength="255"
                autocomplete="name"
            />

            <x-spmb.input
                name="admin_email"
                label="Email Login Admin"
                type="email"
                placeholder="admin@sekolah.sch.id"
                :required="true"
                maxlength="255"
                autocomplete="email"
            />

            <x-spmb.input
                name="admin_password"
                label="Password"
                type="password"
                :required="true"
                hint="Minimal 8 karakter."
                autocomplete="new-password"
            />

            <x-spmb.input
                name="admin_password_confirmation"
                label="Konfirmasi Password"
                type="password"
                :required="true"
                autocomplete="new-password"
                span="2"
            />
        </x-spmb.section>

        <div class="flex flex-col-reverse items-stretch gap-3 border-t border-ink-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-xs text-ink-500">
                Setelah terdaftar, sekolah Anda dapat langsung menerima pendaftaran calon siswa.
            </p>
            <x-spmb.submit target="submit" label="Daftarkan Sekolah" />
        </div>

        @if($errors->any())
            <div class="rounded-lg border border-rose-200 bg-rose-50 p-4">
                <p class="text-sm font-semibold text-rose-800">⚠ Periksa kembali kolom yang ditandai merah.</p>
            </div>
        @endif
    </form>
</div>
