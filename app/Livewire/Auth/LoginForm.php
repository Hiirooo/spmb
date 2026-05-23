<?php

namespace App\Livewire\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

class LoginForm extends Component implements HasForms
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
                TextInput::make('identifier')
                    ->label('Email atau NISN')
                    ->required()
                    ->autofocus()
                    ->helperText('Login dengan email Anda, atau NISN bagi calon murid.'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->revealable(),
                Checkbox::make('remember')
                    ->label('Ingat saya'),
            ])
            ->statePath('data');
    }

    public function submit(): mixed
    {
        $payload = $this->form->getState();
        $key = 'login.'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'data.identifier' => 'Terlalu banyak percobaan. Coba lagi dalam '.RateLimiter::availableIn($key).' detik.',
            ]);
        }

        $identifier = trim($payload['identifier']);
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'nisn';

        if (! Auth::attempt([
            $field => $identifier,
            'password' => $payload['password'],
        ], (bool) ($payload['remember'] ?? false))) {
            RateLimiter::hit($key);
            throw ValidationException::withMessages([
                'data.identifier' => 'Email/NISN atau password salah.',
            ]);
        }

        RateLimiter::clear($key);
        session()->regenerate();

        $user = Auth::user();

        return redirect()->intended($user->isAdmin() ? '/admin' : route('portal'));
    }

    public function render()
    {
        return view('livewire.auth.login-form');
    }
}
