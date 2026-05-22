<?php

namespace App\Filament\Resources\Pendaftars\Schemas;

use App\Support\SpmbDokumen;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PendaftarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Calon Murid')
                    ->columns(2)
                    ->components([
                        TextInput::make('nomor_pendaftaran')
                            ->label('Nomor Pendaftaran')
                            ->disabled()
                            ->dehydrated(false),
                        Select::make('status')
                            ->options([
                                'baru' => 'Baru',
                                'verifikasi' => 'Verifikasi',
                                'diterima' => 'Diterima',
                                'ditolak' => 'Ditolak',
                                'cadangan' => 'Cadangan',
                            ])
                            ->required()
                            ->native(false),
                        TextInput::make('nama_lengkap')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('nisn')
                            ->label('NISN')
                            ->length(10),
                        TextInput::make('nik')
                            ->label('NIK')
                            ->length(16)
                            ->unique(ignoreRecord: true),
                        Select::make('jenis_kelamin')
                            ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                            ->required()
                            ->native(false),
                        TextInput::make('tempat_lahir')->required(),
                        DatePicker::make('tanggal_lahir')->required()->native(false),
                        Textarea::make('alamat')->required()->rows(3)->columnSpanFull(),
                    ]),

                Section::make('Orang Tua / Wali')
                    ->columns(2)
                    ->components([
                        TextInput::make('nama_ayah'),
                        TextInput::make('nama_ibu'),
                        TextInput::make('pekerjaan_ortu'),
                        TextInput::make('penghasilan_ortu'),
                    ]),

                Section::make('Kontak')
                    ->columns(2)
                    ->components([
                        TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                        TextInput::make('no_telepon')->tel()->required()->maxLength(20),
                    ]),

                Section::make('Sekolah')
                    ->columns(2)
                    ->components([
                        TextInput::make('asal_sekolah')->required(),
                        TextInput::make('tahun_lulus')->numeric()->required(),
                        TextInput::make('sekolah_tujuan')->required()->columnSpanFull(),
                    ]),

                Section::make('Jalur Pendaftaran')
                    ->columns(2)
                    ->components([
                        Select::make('jalur_pendaftaran')
                            ->options(SpmbDokumen::JALUR)
                            ->required()
                            ->live()
                            ->native(false),
                        Select::make('kategori_prestasi')
                            ->options(SpmbDokumen::KATEGORI_PRESTASI)
                            ->native(false)
                            ->visible(fn (Get $get): bool => $get('jalur_pendaftaran') === 'prestasi'),
                        Select::make('tingkat_prestasi')
                            ->options(SpmbDokumen::TINGKAT_PRESTASI)
                            ->native(false)
                            ->visible(fn (Get $get): bool => $get('jalur_pendaftaran') === 'prestasi' && $get('kategori_prestasi') === 'non_akademik'),
                        Textarea::make('catatan')
                            ->label('Catatan Panitia')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
