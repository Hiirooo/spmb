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
        return (string) static::scopedQuery()->where('status', 'baru')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return static::scopedQuery();
    }

    protected static function scopedQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();
        if ($user && $user->isSekolahAdmin() && $user->sekolah_id) {
            $query->where('sekolah_id', $user->sekolah_id);
        }
        return $query;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nomor_pendaftaran', 'nama_lengkap', 'nik', 'email'];
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\Pendaftars\RelationManagers\DokumensRelationManager::class,
            \App\Filament\Resources\Pendaftars\RelationManagers\LogsRelationManager::class,
        ];
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
