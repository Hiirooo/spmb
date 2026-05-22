<?php

namespace App\Filament\Resources\Sekolahs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SekolahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Sekolah')
                    ->columns(2)
                    ->components([
                        TextInput::make('npsn')->label('NPSN')->required()->length(8)->unique(ignoreRecord: true),
                        Select::make('jenjang')
                            ->options(['SMA' => 'SMA', 'SMK' => 'SMK', 'SMP' => 'SMP', 'SD' => 'SD'])
                            ->required()->native(false),
                        TextInput::make('nama')->required()->columnSpanFull(),
                        Select::make('status_negeri')
                            ->options(['negeri' => 'Negeri', 'swasta' => 'Swasta'])
                            ->required()->native(false),
                        TextInput::make('kabupaten_kota')->required(),
                        TextInput::make('provinsi')->default('Sumatera Selatan'),
                        Textarea::make('alamat')->rows(2)->columnSpanFull(),
                        Textarea::make('deskripsi')->rows(3)->columnSpanFull(),
                    ]),

                Section::make('Kontak')
                    ->columns(2)
                    ->components([
                        TextInput::make('email_kontak')->email(),
                        TextInput::make('telepon_kontak')->tel(),
                        TextInput::make('website')->url()->columnSpanFull(),
                    ]),

                Section::make('Daya Tampung & Status')
                    ->columns(2)
                    ->components([
                        TextInput::make('daya_tampung_total')->numeric()->minValue(0),
                        Toggle::make('is_active')->label('Sekolah Aktif')->default(true),
                        Toggle::make('is_pendaftaran_buka')->label('Pendaftaran Dibuka')->default(true),
                    ]),
            ]);
    }
}
