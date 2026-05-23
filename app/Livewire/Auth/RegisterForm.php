<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class RegisterForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $nisn = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nisn' => ['nullable', 'string', 'size:10', 'regex:/^[0-9]+$/', 'unique:users,nisn'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    protected function messages(): array
    {
        return [
            'required' => 'Wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'nisn.size' => 'NISN harus 10 digit.',
            'nisn.regex' => 'NISN harus berupa angka.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.min' => 'Password minimal :min karakter.',
        ];
    }

    public function submit(): mixed
    {
        $data = $this->validate();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'nisn' => $data['nisn'] ?: null,
            'password' => $data['password'],
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
