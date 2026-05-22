<?php

namespace App\Livewire;

use App\Models\Pendaftar;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CekStatusForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?Pendaftar $pendaftar = null;

    public bool $notFound = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor_pendaftaran')
                    ->label('Nomor Pendaftaran')
                    ->placeholder('Misal: SMAN-2026-00001')
                    ->required()
                    ->autofocus(),
                TextInput::make('nik')
                    ->label('NIK (16 digit)')
                    ->required()
                    ->length(16)
                    ->rule('regex:/^[0-9]+$/')
                    ->validationMessages(['regex' => 'NIK harus 16 digit angka.']),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $key = 'cek-status.'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            throw ValidationException::withMessages([
                'data.nomor_pendaftaran' => 'Terlalu banyak percobaan. Coba lagi dalam '.RateLimiter::availableIn($key).' detik.',
            ]);
        }
        RateLimiter::hit($key);

        $payload = $this->form->getState();

        $this->pendaftar = Pendaftar::query()
            ->where('nomor_pendaftaran', $payload['nomor_pendaftaran'])
            ->where('nik', $payload['nik'])
            ->with(['sekolah', 'dokumens'])
            ->first();

        $this->notFound = $this->pendaftar === null;
    }

    public function reset_form(): void
    {
        $this->pendaftar = null;
        $this->notFound = false;
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.cek-status-form');
    }
}
