<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class RegisterForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'users', column: 'email'),
                TextInput::make('nisn')
                    ->label('NISN (10 digit, opsional)')
                    ->length(10)
                    ->rule('regex:/^[0-9]+$/')
                    ->validationMessages(['regex' => 'NISN harus 10 digit angka.'])
                    ->unique(table: 'users', column: 'nisn')
                    ->helperText('Diisi jika sudah memiliki NISN — bisa digunakan sebagai alternatif login.'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->rule(Password::min(8))
                    ->revealable(),
                TextInput::make('password_confirmation')
                    ->label('Konfirmasi Password')
                    ->password()
                    ->required()
                    ->same('password')
                    ->revealable()
                    ->dehydrated(false),
            ])
            ->statePath('data');
    }

    public function submit(): mixed
    {
        $payload = $this->form->getState();

        $user = User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'nisn' => $payload['nisn'] ?? null,
            'password' => $payload['password'],
            'role' => 'pendaftar',
        ]);

        Auth::login($user, remember: true);

        session()->regenerate();

        return redirect()->route('portal');
    }

    public function render()
    {
        return view('livewire.auth.register-form');
    }
}
