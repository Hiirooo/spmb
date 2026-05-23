<div>
    <form wire:submit="submit" class="space-y-5">
        <x-spmb.input
            name="name"
            label="Nama Lengkap"
            placeholder="Sesuai akta kelahiran"
            :required="true"
            autocomplete="name"
            :autofocus="true"
            maxlength="255"
        />

        <x-spmb.input
            name="email"
            label="Email"
            type="email"
            placeholder="nama@contoh.com"
            :required="true"
            autocomplete="email"
            maxlength="255"
        />

        <x-spmb.input
            name="nisn"
            label="NISN (opsional)"
            placeholder="10 digit"
            inputmode="numeric"
            maxlength="10"
            mono
            hint="Diisi jika sudah memiliki NISN — bisa digunakan sebagai alternatif login."
        />

        <x-spmb.input
            name="password"
            label="Password"
            type="password"
            :required="true"
            autocomplete="new-password"
            hint="Minimal 8 karakter."
        />

        <x-spmb.input
            name="password_confirmation"
            label="Konfirmasi Password"
            type="password"
            :required="true"
            autocomplete="new-password"
        />

        <x-spmb.submit target="submit" label="Buat Akun" :fullWidth="true" />
    </form>
</div>
