<?php

namespace App\Livewire;

use App\Models\Pendaftar;
use App\Support\SpmbDokumen;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
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
                Section::make('Identitas Calon Murid')
                    ->description('Data pribadi sesuai Kartu Keluarga & Akta Kelahiran')
                    ->columns(2)
                    ->components([
                        TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('nisn')
                            ->label('NISN')
                            ->required()
                            ->length(10)
                            ->rule('regex:/^[0-9]+$/')
                            ->validationMessages(['regex' => 'NISN harus berupa 10 digit angka.']),
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
                            ->maxDate(now()->subYears(12)),
                        Textarea::make('alamat')
                            ->label('Alamat Lengkap (sesuai KK)')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Data Orang Tua / Wali')
                    ->columns(2)
                    ->components([
                        TextInput::make('nama_ayah')
                            ->label('Nama Ayah')
                            ->required(),
                        TextInput::make('nama_ibu')
                            ->label('Nama Ibu')
                            ->required(),
                        TextInput::make('pekerjaan_ortu')
                            ->label('Pekerjaan Orang Tua / Wali')
                            ->required(),
                        Select::make('penghasilan_ortu')
                            ->label('Penghasilan Bulanan Orang Tua')
                            ->options([
                                '< 1 juta' => 'Kurang dari Rp 1.000.000',
                                '1-3 juta' => 'Rp 1.000.000 – Rp 3.000.000',
                                '3-5 juta' => 'Rp 3.000.000 – Rp 5.000.000',
                                '5-10 juta' => 'Rp 5.000.000 – Rp 10.000.000',
                                '> 10 juta' => 'Lebih dari Rp 10.000.000',
                            ])
                            ->required()
                            ->native(false),
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
                            ->label('Nomor WhatsApp Aktif')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ]),

                Section::make('Asal Sekolah')
                    ->columns(2)
                    ->components([
                        TextInput::make('asal_sekolah')
                            ->label('Asal SMP / Sederajat')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('tahun_lulus')
                            ->label('Tahun Lulus')
                            ->numeric()
                            ->required()
                            ->minValue(2020)
                            ->maxValue((int) now()->format('Y')),
                    ]),

                Section::make('Pilihan Pendaftaran')
                    ->description('Sesuai Juknis SPMB SMA Negeri Provinsi Sumsel TA 2026/2027')
                    ->columns(2)
                    ->components([
                        Select::make('jalur_pendaftaran')
                            ->label('Jalur Pendaftaran')
                            ->options(SpmbDokumen::JALUR)
                            ->required()
                            ->live()
                            ->native(false)
                            ->helperText('Hanya boleh memilih satu jalur. Sistem akan menolak pendaftaran ganda.'),
                        Select::make('sekolah_tujuan')
                            ->label('Sekolah Tujuan')
                            ->options([
                                'SMAN 1 Palembang' => 'SMAN 1 Palembang',
                                'SMAN 3 Palembang' => 'SMAN 3 Palembang',
                                'SMAN 6 Palembang' => 'SMAN 6 Palembang',
                                'SMAN 17 Palembang' => 'SMAN 17 Palembang',
                                'SMAN 1 Lubuklinggau' => 'SMAN 1 Lubuklinggau',
                                'SMAN 1 Prabumulih' => 'SMAN 1 Prabumulih',
                                'SMAN 1 Pagar Alam' => 'SMAN 1 Pagar Alam',
                                'SMAN Sumsel (Sampoerna Academy)' => 'SMAN Sumsel (Sampoerna Academy)',
                            ])
                            ->required()
                            ->searchable()
                            ->native(false),
                        Select::make('kategori_prestasi')
                            ->label('Kategori Prestasi')
                            ->options(SpmbDokumen::KATEGORI_PRESTASI)
                            ->required()
                            ->native(false)
                            ->visible(fn (Get $get): bool => $get('jalur_pendaftaran') === 'prestasi'),
                        Select::make('tingkat_prestasi')
                            ->label('Tingkat Prestasi')
                            ->options(SpmbDokumen::TINGKAT_PRESTASI)
                            ->required()
                            ->native(false)
                            ->visible(fn (Get $get): bool => $get('jalur_pendaftaran') === 'prestasi' && $get('kategori_prestasi') === 'non_akademik'),
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
            ->body('Lanjutkan dengan mengunggah dokumen persyaratan.')
            ->success()
            ->send();

        return redirect()->route('portal.dokumen');
    }

    public function render()
    {
        return view('livewire.pendaftaran-form');
    }
}
