<?php

namespace App\Livewire\Sekolah;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class RegisterSekolahForm extends Component
{
    public string $npsn = '';
    public string $nama = '';
    public string $jenjang = 'SMA';
    public string $status_negeri = 'negeri';
    public string $kabupaten_kota = '';
    public string $provinsi = 'Sumatera Selatan';
    public string $alamat = '';
    public string $deskripsi = '';

    public string $email_kontak = '';
    public string $telepon_kontak = '';
    public string $website = '';
    public ?int $daya_tampung_total = 0;

    public string $admin_name = '';
    public string $admin_email = '';
    public string $admin_password = '';
    public string $admin_password_confirmation = '';

    protected function rules(): array
    {
        return [
            'npsn' => ['required', 'string', 'size:8', 'regex:/^[0-9]+$/', 'unique:sekolahs,npsn'],
            'nama' => ['required', 'string', 'max:255'],
            'jenjang' => ['required', 'in:SMA,SMK,SMP,SD'],
            'status_negeri' => ['required', 'in:negeri,swasta'],
            'kabupaten_kota' => ['required', 'string', 'max:120'],
            'provinsi' => ['required', 'string', 'max:120'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],

            'email_kontak' => ['nullable', 'email', 'max:255'],
            'telepon_kontak' => ['nullable', 'string', 'max:25'],
            'website' => ['nullable', 'url', 'max:255'],
            'daya_tampung_total' => ['nullable', 'integer', 'min:0', 'max:5000'],

            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'admin_password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    protected function messages(): array
    {
        return [
            'required' => 'Wajib diisi.',
            'npsn.size' => 'NPSN harus 8 digit.',
            'npsn.regex' => 'NPSN harus berupa angka.',
            'npsn.unique' => 'NPSN sudah terdaftar.',
            'admin_email.unique' => 'Email admin sudah terdaftar.',
            'admin_password.confirmed' => 'Konfirmasi password tidak sama.',
            'admin_password.min' => 'Password minimal :min karakter.',
            'in' => 'Pilihan tidak valid.',
            'email' => 'Format email tidak valid.',
            'url' => 'Format URL tidak valid.',
            'integer' => 'Harus berupa angka.',
        ];
    }

    public function jenjangOptions(): array
    {
        return [
            ['value' => 'SMA', 'label' => 'SMA'],
            ['value' => 'SMK', 'label' => 'SMK'],
            ['value' => 'SMP', 'label' => 'SMP'],
            ['value' => 'SD', 'label' => 'SD'],
        ];
    }

    public function statusOptions(): array
    {
        return [
            ['value' => 'negeri', 'label' => 'Negeri'],
            ['value' => 'swasta', 'label' => 'Swasta'],
        ];
    }

    public function kabupatenOptions(): array
    {
        $list = [
            'Kota Palembang', 'Kota Lubuklinggau', 'Kota Prabumulih', 'Kota Pagar Alam',
            'Kabupaten Banyuasin', 'Kabupaten Empat Lawang', 'Kabupaten Lahat',
            'Kabupaten Muara Enim', 'Kabupaten Musi Banyuasin', 'Kabupaten Musi Rawas',
            'Kabupaten Musi Rawas Utara', 'Kabupaten Ogan Ilir', 'Kabupaten Ogan Komering Ilir',
            'Kabupaten Ogan Komering Ulu', 'Kabupaten Ogan Komering Ulu Selatan',
            'Kabupaten Ogan Komering Ulu Timur', 'Kabupaten Penukal Abab Lematang Ilir (PALI)',
        ];
        return collect($list)->map(fn ($n) => ['value' => $n, 'label' => $n])->values()->all();
    }

    public function submit(): mixed
    {
        $data = $this->validate();

        $sekolah = Sekolah::create([
            'npsn' => $data['npsn'],
            'nama' => $data['nama'],
            'jenjang' => $data['jenjang'],
            'status_negeri' => $data['status_negeri'],
            'kabupaten_kota' => $data['kabupaten_kota'],
            'provinsi' => $data['provinsi'],
            'alamat' => $data['alamat'] ?? null,
            'email_kontak' => $data['email_kontak'] ?? null,
            'telepon_kontak' => $data['telepon_kontak'] ?? null,
            'website' => $data['website'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'daya_tampung_total' => $data['daya_tampung_total'] ?? 0,
            'kuota_jalur' => Sekolah::defaultKuota(),
            'is_active' => true,
            'is_pendaftaran_buka' => true,
        ]);

        $admin = User::create([
            'name' => $data['admin_name'],
            'email' => $data['admin_email'],
            'password' => $data['admin_password'],
            'role' => User::ROLE_SEKOLAH_ADMIN,
            'sekolah_id' => $sekolah->id,
        ]);

        Auth::login($admin, remember: true);
        session()->regenerate();

        return redirect('/admin');
    }

    public function render()
    {
        return view('livewire.sekolah.register-sekolah-form');
    }
}
