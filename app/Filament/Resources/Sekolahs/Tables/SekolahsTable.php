<?php

namespace App\Filament\Resources\Sekolahs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SekolahsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('npsn')->searchable()->sortable()->copyable(),
                TextColumn::make('nama')->searchable()->sortable()->limit(40),
                TextColumn::make('jenjang')->badge(),
                TextColumn::make('status_negeri')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $s): string => ucfirst($s ?? '-')),
                TextColumn::make('kabupaten_kota')->label('Kab/Kota')->searchable()->limit(24),
                TextColumn::make('pendaftars_count')
                    ->label('Pendaftar')
                    ->counts('pendaftars')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('daya_tampung_total')->label('Kuota')->numeric(),
                IconColumn::make('is_active')->label('Aktif')->boolean(),
                IconColumn::make('is_pendaftaran_buka')->label('Buka')->boolean(),
                TextColumn::make('created_at')->dateTime('d M Y')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('nama')
            ->filters([
                SelectFilter::make('jenjang')->options(['SMA' => 'SMA', 'SMK' => 'SMK', 'SMP' => 'SMP', 'SD' => 'SD']),
                SelectFilter::make('status_negeri')->options(['negeri' => 'Negeri', 'swasta' => 'Swasta']),
                TernaryFilter::make('is_active')->label('Aktif'),
                TernaryFilter::make('is_pendaftaran_buka')->label('Pendaftaran buka'),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
