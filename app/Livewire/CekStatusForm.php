<?php

namespace App\Livewire;

use App\Models\Pendaftar;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CekStatusForm extends Component
{
    public string $nomor_pendaftaran = '';
    public string $nik = '';

    public ?Pendaftar $pendaftar = null;
    public bool $notFound = false;

    protected function rules(): array
    {
        return [
            'nomor_pendaftaran' => ['required', 'string', 'max:50'],
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
        ];
    }

    protected function messages(): array
    {
        return [
            'required' => 'Wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.regex' => 'NIK harus berupa angka.',
        ];
    }

    public function submit(): void
    {
        $key = 'cek-status.'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            throw ValidationException::withMessages([
                'nomor_pendaftaran' => 'Terlalu banyak percobaan. Coba lagi dalam '.RateLimiter::availableIn($key).' detik.',
            ]);
        }
        RateLimiter::hit($key);

        $data = $this->validate();

        $this->pendaftar = Pendaftar::query()
            ->where('nomor_pendaftaran', $data['nomor_pendaftaran'])
            ->where('nik', $data['nik'])
            ->with(['sekolah', 'dokumens'])
            ->first();

        $this->notFound = $this->pendaftar === null;
    }

    public function reset_form(): void
    {
        $this->pendaftar = null;
        $this->notFound = false;
        $this->nomor_pendaftaran = '';
        $this->nik = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.cek-status-form');
    }
}
