<?php

namespace App\Livewire;

use App\Models\Pendaftar;
use App\Models\Sekolah;
use App\Support\SpmbDokumen;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PendaftaranForm extends Component
{
    public Sekolah $sekolah;

    public ?string $jalurPreset = null;

    public string $nama_lengkap = '';
    public string $nisn = '';
    public string $nik = '';
    public string $jenis_kelamin = '';
    public string $tempat_lahir = '';
    public string $tanggal_lahir = '';
    public string $alamat = '';

    public string $nama_ayah = '';
    public string $nama_ibu = '';
    public string $pekerjaan_ortu = '';
    public string $penghasilan_ortu = '';

    public string $email = '';
    public string $no_telepon = '';

    public string $asal_sekolah = '';
    public ?int $tahun_lulus = null;

    public string $jalur_pendaftaran = '';
    public string $kategori_prestasi = '';
    public string $tingkat_prestasi = '';

    public function mount(Sekolah $sekolah, ?string $jalur = null): void
    {
        $this->sekolah = $sekolah;
        $this->jalurPreset = $jalur && array_key_exists($jalur, SpmbDokumen::JALUR) ? $jalur : null;

        $user = Auth::user();
        $this->nama_lengkap = $user?->name ?? '';
        $this->email = $user?->email ?? '';
        $this->nisn = $user?->nisn ?? '';
        $this->jalur_pendaftaran = $this->jalurPreset ?? '';
        $this->tahun_lulus = (int) now()->format('Y');
    }

    protected function rules(): array
    {
        $maxBirth = now()->subYears(12)->format('Y-m-d');
        $year = (int) now()->format('Y');

        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'string', 'size:10', 'regex:/^[0-9]+$/'],
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', 'unique:pendaftars,nik'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['required', 'string', 'max:120'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:'.$maxBirth],
            'alamat' => ['required', 'string', 'min:10', 'max:500'],

            'nama_ayah' => ['required', 'string', 'max:120'],
            'nama_ibu' => ['required', 'string', 'max:120'],
            'pekerjaan_ortu' => ['required', 'string', 'max:120'],
            'penghasilan_ortu' => ['required', 'in:< 1 juta,1-3 juta,3-5 juta,5-10 juta,> 10 juta'],

            'email' => ['required', 'email', 'max:255', 'unique:pendaftars,email'],
            'no_telepon' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],

            'asal_sekolah' => ['required', 'string', 'max:255'],
            'tahun_lulus' => ['required', 'integer', 'min:2020', 'max:'.$year],

            'jalur_pendaftaran' => ['required', 'in:'.implode(',', array_keys(SpmbDokumen::JALUR))],
            'kategori_prestasi' => ['required_if:jalur_pendaftaran,prestasi', 'nullable', 'in:'.implode(',', array_keys(SpmbDokumen::KATEGORI_PRESTASI))],
            'tingkat_prestasi' => ['required_if:kategori_prestasi,non_akademik', 'nullable', 'in:'.implode(',', array_keys(SpmbDokumen::TINGKAT_PRESTASI))],
        ];
    }

    protected function messages(): array
    {
        return [
            'required' => 'Wajib diisi.',
            'required_if' => 'Wajib diisi.',
            'email' => 'Format email tidak valid.',
            'max' => 'Maksimal :max karakter.',
            'min' => 'Minimal :min karakter.',
            'size' => 'Harus tepat :size karakter.',
            'regex' => 'Format tidak valid.',
            'unique' => 'Sudah terdaftar di sistem.',
            'in' => 'Pilihan tidak valid.',
            'date' => 'Tanggal tidak valid.',
            'before_or_equal' => 'Tanggal lahir tidak valid (minimal usia 12 tahun).',
            'integer' => 'Harus berupa angka.',
            'nisn.regex' => 'NISN harus 10 digit angka.',
            'nik.regex' => 'NIK harus 16 digit angka.',
            'no_telepon.regex' => 'Format telepon tidak valid.',
        ];
    }

    public function updatedJalurPendaftaran(): void
    {
        if ($this->jalur_pendaftaran !== 'prestasi') {
            $this->kategori_prestasi = '';
            $this->tingkat_prestasi = '';
        }
    }

    public function updatedKategoriPrestasi(): void
    {
        if ($this->kategori_prestasi !== 'non_akademik') {
            $this->tingkat_prestasi = '';
        }
    }

    #[Computed]
    public function jalurOptions(): array
    {
        $penuh = $this->sekolah->jalurPenuhList();
        $opts = [];
        foreach (SpmbDokumen::JALUR as $key => $label) {
            $opts[] = [
                'value' => $key,
                'label' => $label,
                'penuh' => in_array($key, $penuh, true),
            ];
        }
        return $opts;
    }

    public function submit()
    {
        $data = $this->validate();

        if ($this->sekolah->isJalurPenuh($data['jalur_pendaftaran'])) {
            $this->addError('jalur_pendaftaran', 'Kuota jalur '.$data['jalur_pendaftaran'].' telah penuh.');
            return null;
        }

        $payload = $data + [
            'status' => 'baru',
            'user_id' => Auth::id(),
            'sekolah_id' => $this->sekolah->id,
            'sekolah_tujuan' => $this->sekolah->nama,
        ];

        Pendaftar::create($payload);

        session()->flash('flash-success', 'Pendaftaran berhasil! Lanjutkan dengan mengunggah dokumen.');

        return redirect()->route('portal.dokumen');
    }

    public function render()
    {
        return view('livewire.pendaftaran-form');
    }
}
