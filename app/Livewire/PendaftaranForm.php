<?php

namespace App\Livewire;

use App\Models\Pendaftar;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PendaftaranForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'nama_lengkap' => $user?->name,
            'email' => $user?->email,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Calon Mahasiswa')
                    ->description('Data pribadi sesuai kartu identitas')
                    ->columns(2)
                    ->components([
                        TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->length(16)
                            ->rule('regex:/^[0-9]+$/')
                            ->validationMessages(['regex' => 'NIK harus berupa 16 digit angka.'])
                            ->unique(table: 'pendaftars', column: 'nik'),
                        Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                            ->required()
                            ->native(false),
                        TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->required(),
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->native(false)
                            ->maxDate(now()->subYears(15)),
                        Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Kontak')
                    ->columns(2)
                    ->components([
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(table: 'pendaftars', column: 'email'),
                        TextInput::make('no_telepon')
                            ->label('Nomor Telepon (WhatsApp)')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ]),

                Section::make('Riwayat Pendidikan')
                    ->columns(2)
                    ->components([
                        TextInput::make('asal_sekolah')
                            ->label('Asal Sekolah')
                            ->required(),
                        TextInput::make('tahun_lulus')
                            ->label('Tahun Lulus')
                            ->numeric()
                            ->required()
                            ->minValue(1990)
                            ->maxValue((int) now()->format('Y')),
                    ]),

                Section::make('Pilihan Pendaftaran')
                    ->columns(2)
                    ->components([
                        Select::make('program_studi')
                            ->label('Program Studi')
                            ->options([
                                'Teknik Informatika' => 'Teknik Informatika',
                                'Sistem Informasi' => 'Sistem Informasi',
                                'Manajemen' => 'Manajemen',
                                'Akuntansi' => 'Akuntansi',
                                'Hukum' => 'Hukum',
                                'Psikologi' => 'Psikologi',
                            ])
                            ->required()
                            ->searchable()
                            ->native(false),
                        Select::make('jalur_pendaftaran')
                            ->label('Jalur Pendaftaran')
                            ->options([
                                'reguler' => 'Reguler',
                                'prestasi' => 'Prestasi',
                                'beasiswa' => 'Beasiswa',
                                'transfer' => 'Transfer',
                            ])
                            ->required()
                            ->native(false),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): mixed
    {
        $payload = $this->form->getState();
        $payload['status'] = 'baru';
        $payload['user_id'] = Auth::id();

        $pendaftar = Pendaftar::create($payload);

        Notification::make()
            ->title('Pendaftaran berhasil!')
            ->body('Nomor pendaftaran Anda: '.$pendaftar->nomor_pendaftaran)
            ->success()
            ->send();

        return redirect()->route('daftar.sukses', ['nomor' => $pendaftar->nomor_pendaftaran]);
    }

    public function render()
    {
        return view('livewire.pendaftaran-form');
    }
}
