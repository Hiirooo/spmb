<?php

namespace App\Filament\Pages;

use App\Models\Sekolah;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SekolahSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Pengaturan Sekolah';

    protected static ?string $title = 'Pengaturan Sekolah';

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.sekolah-settings';

    public ?array $data = [];

    public ?Sekolah $sekolah = null;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isSekolahAdmin() ?? false;
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isSekolahAdmin() ?? false;
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->isSekolahAdmin(), 403);

        $this->sekolah = auth()->user()->sekolah;

        $kuota = $this->sekolah->kuota_jalur ?? Sekolah::defaultKuota();

        $this->form->fill([
            'nama' => $this->sekolah->nama,
            'alamat' => $this->sekolah->alamat,
            'email_kontak' => $this->sekolah->email_kontak,
            'telepon_kontak' => $this->sekolah->telepon_kontak,
            'website' => $this->sekolah->website,
            'deskripsi' => $this->sekolah->deskripsi,
            'daya_tampung_total' => $this->sekolah->daya_tampung_total,
            'kuota_afirmasi' => $kuota['afirmasi'] ?? 30,
            'kuota_domisili' => $kuota['domisili'] ?? 30,
            'kuota_mutasi' => $kuota['mutasi'] ?? 5,
            'kuota_prestasi' => $kuota['prestasi'] ?? 35,
            'is_pendaftaran_buka' => $this->sekolah->is_pendaftaran_buka,
            'pendaftaran_dibuka_pada' => $this->sekolah->pendaftaran_dibuka_pada,
            'pendaftaran_ditutup_pada' => $this->sekolah->pendaftaran_ditutup_pada,
            'latitude' => $this->sekolah->latitude,
            'longitude' => $this->sekolah->longitude,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil Sekolah')
                    ->columns(2)
                    ->components([
                        TextInput::make('nama')->required()->columnSpanFull(),
                        TextInput::make('email_kontak')->label('Email')->email(),
                        TextInput::make('telepon_kontak')->label('Telepon')->tel(),
                        TextInput::make('website')->url()->columnSpanFull(),
                        Textarea::make('alamat')->rows(2)->columnSpanFull(),
                        Textarea::make('deskripsi')->rows(3)->columnSpanFull(),
                    ]),

                Section::make('Koordinat Lokasi')
                    ->description('Untuk fitur otomatis hitung jarak calon siswa ke sekolah.')
                    ->columns(2)
                    ->components([
                        TextInput::make('latitude')->numeric()->step('0.0000001')->placeholder('-2.9756'),
                        TextInput::make('longitude')->numeric()->step('0.0000001')->placeholder('104.7458'),
                    ]),

                Section::make('Kuota & Daya Tampung')
                    ->description('Total persentase kuota jalur idealnya 100%. Sesuai Juknis: Afirmasi min 30%, Domisili min 30%, Mutasi max 5%, Prestasi min 35%.')
                    ->columns(3)
                    ->components([
                        TextInput::make('daya_tampung_total')
                            ->label('Daya Tampung Total (kursi)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->columnSpanFull(),
                        TextInput::make('kuota_afirmasi')->label('Afirmasi (%)')->numeric()->required()->minValue(0)->maxValue(100)->suffix('%'),
                        TextInput::make('kuota_domisili')->label('Domisili (%)')->numeric()->required()->minValue(0)->maxValue(100)->suffix('%'),
                        TextInput::make('kuota_mutasi')->label('Mutasi (%)')->numeric()->required()->minValue(0)->maxValue(100)->suffix('%'),
                        TextInput::make('kuota_prestasi')->label('Prestasi (%)')->numeric()->required()->minValue(0)->maxValue(100)->suffix('%'),
                    ]),

                Section::make('Status Pendaftaran')
                    ->columns(2)
                    ->components([
                        Toggle::make('is_pendaftaran_buka')
                            ->label('Pendaftaran Dibuka')
                            ->columnSpanFull()
                            ->helperText('Matikan untuk menutup pendaftaran sementara.'),
                        DateTimePicker::make('pendaftaran_dibuka_pada')->label('Buka Sejak')->native(false),
                        DateTimePicker::make('pendaftaran_ditutup_pada')->label('Tutup Pada')->native(false),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $payload = $this->form->getState();

        $totalKuota = $payload['kuota_afirmasi'] + $payload['kuota_domisili']
            + $payload['kuota_mutasi'] + $payload['kuota_prestasi'];

        if ($totalKuota !== 100) {
            Notification::make()
                ->title("Total kuota harus 100%, saat ini {$totalKuota}%.")
                ->warning()
                ->send();
            return;
        }

        $this->sekolah->update([
            'nama' => $payload['nama'],
            'alamat' => $payload['alamat'] ?? null,
            'email_kontak' => $payload['email_kontak'] ?? null,
            'telepon_kontak' => $payload['telepon_kontak'] ?? null,
            'website' => $payload['website'] ?? null,
            'deskripsi' => $payload['deskripsi'] ?? null,
            'daya_tampung_total' => $payload['daya_tampung_total'],
            'latitude' => $payload['latitude'] ?? null,
            'longitude' => $payload['longitude'] ?? null,
            'kuota_jalur' => [
                'afirmasi' => (int) $payload['kuota_afirmasi'],
                'domisili' => (int) $payload['kuota_domisili'],
                'mutasi' => (int) $payload['kuota_mutasi'],
                'prestasi' => (int) $payload['kuota_prestasi'],
            ],
            'is_pendaftaran_buka' => (bool) $payload['is_pendaftaran_buka'],
            'pendaftaran_dibuka_pada' => $payload['pendaftaran_dibuka_pada'] ?? null,
            'pendaftaran_ditutup_pada' => $payload['pendaftaran_ditutup_pada'] ?? null,
        ]);

        Notification::make()
            ->title('Pengaturan sekolah disimpan.')
            ->success()
            ->send();
    }
}
