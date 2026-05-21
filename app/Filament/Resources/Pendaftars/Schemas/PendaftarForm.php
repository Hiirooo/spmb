<?php

namespace App\Filament\Resources\Pendaftars\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PendaftarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Calon Mahasiswa')
                    ->description('Data pribadi pendaftar sesuai kartu identitas')
                    ->columns(2)
                    ->components([
                        TextInput::make('nomor_pendaftaran')
                            ->label('Nomor Pendaftaran')
                            ->placeholder('Auto-generate jika dikosongkan')
                            ->maxLength(20)
                            ->unique(ignoreRecord: true),
                        Select::make('status')
                            ->options([
                                'baru' => 'Baru',
                                'verifikasi' => 'Verifikasi',
                                'diterima' => 'Diterima',
                                'ditolak' => 'Ditolak',
                                'cadangan' => 'Cadangan',
                            ])
                            ->default('baru')
                            ->required()
                            ->native(false),
                        TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->length(16)
                            ->unique(ignoreRecord: true),
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
                            ->maxDate(now()),
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
                            ->unique(ignoreRecord: true),
                        TextInput::make('no_telepon')
                            ->label('Nomor Telepon')
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

                Section::make('Pendaftaran')
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
                        Textarea::make('catatan')
                            ->label('Catatan Admin')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
