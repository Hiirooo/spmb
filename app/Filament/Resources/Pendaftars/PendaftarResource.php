<?php

namespace App\Filament\Resources\Pendaftars;

use App\Filament\Resources\Pendaftars\Pages\CreatePendaftar;
use App\Filament\Resources\Pendaftars\Pages\EditPendaftar;
use App\Filament\Resources\Pendaftars\Pages\ListPendaftars;
use App\Filament\Resources\Pendaftars\Schemas\PendaftarForm;
use App\Filament\Resources\Pendaftars\Tables\PendaftarsTable;
use App\Models\Pendaftar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PendaftarResource extends Resource
{
    protected static ?string $model = Pendaftar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $navigationLabel = 'Pendaftar';

    protected static ?string $modelLabel = 'Pendaftar';

    protected static ?string $pluralModelLabel = 'Pendaftar';

    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public static function form(Schema $schema): Schema
    {
        return PendaftarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PendaftarsTable::configure($table);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Pendaftar::where('status', 'baru')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nomor_pendaftaran', 'nama_lengkap', 'nik', 'email'];
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPendaftars::route('/'),
            'create' => CreatePendaftar::route('/create'),
            'edit' => EditPendaftar::route('/{record}/edit'),
        ];
    }
}
