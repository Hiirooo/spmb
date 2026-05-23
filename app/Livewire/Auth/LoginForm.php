<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LoginForm extends Component
{
    public string $identifier = '';
    public string $password = '';
    public bool $remember = false;

    protected function rules(): array
    {
        return [
            'identifier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:1'],
            'remember' => ['boolean'],
        ];
    }

    protected function messages(): array
    {
        return [
            'required' => 'Wajib diisi.',
        ];
    }

    public function submit(): mixed
    {
        $data = $this->validate();

        $key = 'login.'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'identifier' => 'Terlalu banyak percobaan. Coba lagi dalam '.RateLimiter::availableIn($key).' detik.',
            ]);
        }

        $identifier = trim($data['identifier']);
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'nisn';

        if (! Auth::attempt([
            $field => $identifier,
            'password' => $data['password'],
        ], (bool) ($data['remember'] ?? false))) {
            RateLimiter::hit($key);
            throw ValidationException::withMessages([
                'identifier' => 'Email/NISN atau password salah.',
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
