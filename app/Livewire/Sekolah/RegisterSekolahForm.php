<?php

namespace App\Livewire\Sekolah;

use App\Models\Sekolah;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class RegisterSekolahForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'jenjang' => 'SMA',
            'status_negeri' => 'negeri',
            'provinsi' => 'Sumatera Selatan',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Sekolah')
                    ->columns(2)
                    ->components([
                        TextInput::make('npsn')
                            ->label('NPSN')
                            ->required()
                            ->length(8)
                            ->rule('regex:/^[0-9]+$/')
                            ->validationMessages(['regex' => 'NPSN harus 8 digit angka.'])
                            ->unique(table: 'sekolahs', column: 'npsn'),
                        Select::make('jenjang')
                            ->options(['SMA' => 'SMA', 'SMK' => 'SMK', 'SMP' => 'SMP', 'SD' => 'SD'])
                            ->required()
                            ->native(false),
                        TextInput::make('nama')
                            ->label('Nama Sekolah')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('status_negeri')
                            ->label('Status')
                            ->options(['negeri' => 'Negeri', 'swasta' => 'Swasta'])
                            ->required()
                            ->native(false),
                        Select::make('kabupaten_kota')
                            ->label('Kabupaten/Kota')
                            ->options($this->kabupatenSumselOptions())
                            ->required()
                            ->searchable()
                            ->native(false),
                        Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('deskripsi')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Kontak Sekolah')
                    ->columns(2)
                    ->components([
                        TextInput::make('email_kontak')
                            ->label('Email Sekolah')
                            ->email(),
                        TextInput::make('telepon_kontak')
                            ->label('Telepon Sekolah')
                            ->tel(),
                        TextInput::make('website')
                            ->label('Website (opsional)')
                            ->url()
                            ->columnSpanFull(),
                        TextInput::make('daya_tampung_total')
                            ->label('Daya Tampung Total Tahun Ini')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ]),

                Section::make('Akun Admin Sekolah')
                    ->description('Akun ini akan digunakan untuk mengelola pendaftaran dan verifikasi siswa.')
                    ->columns(2)
                    ->components([
                        TextInput::make('admin_name')
                            ->label('Nama Admin')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('admin_email')
                            ->label('Email Login Admin')
                            ->email()
                            ->required()
                            ->unique(table: 'users', column: 'email'),
                        TextInput::make('admin_password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->rule(Password::min(8))
                            ->revealable(),
                        TextInput::make('admin_password_confirmation')
                            ->label('Konfirmasi Password')
                            ->password()
                            ->required()
                            ->same('admin_password')
                            ->revealable()
                            ->dehydrated(false),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): mixed
    {
        $payload = $this->form->getState();

        $sekolah = Sekolah::create([
            'npsn' => $payload['npsn'],
            'nama' => $payload['nama'],
            'jenjang' => $payload['jenjang'],
            'status_negeri' => $payload['status_negeri'],
            'kabupaten_kota' => $payload['kabupaten_kota'],
            'provinsi' => $payload['provinsi'] ?? 'Sumatera Selatan',
            'alamat' => $payload['alamat'] ?? null,
            'email_kontak' => $payload['email_kontak'] ?? null,
            'telepon_kontak' => $payload['telepon_kontak'] ?? null,
            'website' => $payload['website'] ?? null,
            'deskripsi' => $payload['deskripsi'] ?? null,
            'daya_tampung_total' => $payload['daya_tampung_total'] ?? 0,
            'kuota_jalur' => Sekolah::defaultKuota(),
            'is_active' => true,
            'is_pendaftaran_buka' => true,
        ]);

        $admin = User::create([
            'name' => $payload['admin_name'],
            'email' => $payload['admin_email'],
            'password' => $payload['admin_password'],
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

    private function kabupatenSumselOptions(): array
    {
        $list = [
            'Kota Palembang', 'Kota Lubuklinggau', 'Kota Prabumulih', 'Kota Pagar Alam',
            'Kabupaten Banyuasin', 'Kabupaten Empat Lawang', 'Kabupaten Lahat',
            'Kabupaten Muara Enim', 'Kabupaten Musi Banyuasin', 'Kabupaten Musi Rawas',
            'Kabupaten Musi Rawas Utara', 'Kabupaten Ogan Ilir', 'Kabupaten Ogan Komering Ilir',
            'Kabupaten Ogan Komering Ulu', 'Kabupaten Ogan Komering Ulu Selatan',
            'Kabupaten Ogan Komering Ulu Timur', 'Kabupaten Penukal Abab Lematang Ilir (PALI)',
        ];
        return array_combine($list, $list);
    }
}
