<div>
    <form wire:submit="submit" class="space-y-5">
        <x-spmb.input
            name="identifier"
            label="Email atau NISN"
            placeholder="nama@contoh.com atau 0012345678"
            :required="true"
            autocomplete="username"
            :autofocus="true"
            hint="Login dengan email Anda, atau NISN bagi calon murid."
        />

        <x-spmb.input
            name="password"
            label="Password"
            type="password"
            :required="true"
            autocomplete="current-password"
        />

        <x-spmb.checkbox name="remember" label="Ingat saya" />

        <x-spmb.submit target="submit" label="Masuk" :fullWidth="true" />
    </form>
</div>
