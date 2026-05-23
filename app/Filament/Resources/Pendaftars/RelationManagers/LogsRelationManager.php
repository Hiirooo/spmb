<?php

namespace App\Filament\Resources\Pendaftars\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LogsRelationManager extends RelationManager
{
    protected static string $relationship = 'logs';

    protected static ?string $title = 'Riwayat Aktivitas';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('action')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i')
                    ->size('sm')
                    ->color('gray'),
                TextColumn::make('action')
                    ->label('Aksi')
                    ->badge()
                    ->formatStateUsing(fn (?string $s): string => match ($s) {
                        'pendaftaran_dibuat' => 'Pendaftaran Dibuat',
                        'status_diubah' => 'Status Diubah',
                        'dokumen_diunggah' => 'Dokumen Diunggah',
                        'dokumen_diverifikasi' => 'Dokumen Diverifikasi',
                        default => $s ?? '-',
                    })
                    ->color(fn (?string $s): string => match ($s) {
                        'pendaftaran_dibuat' => 'success',
                        'status_diubah' => 'warning',
                        'dokumen_diunggah' => 'info',
                        'dokumen_diverifikasi' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('user.name')
                    ->label('Oleh')
                    ->placeholder('Sistem'),
                TextColumn::make('from')
                    ->label('Dari')
                    ->placeholder('—')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('to')
                    ->label('Ke')
                    ->placeholder('—')
                    ->badge(),
                TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->catatan),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('action')
                    ->options([
                        'pendaftaran_dibuat' => 'Pendaftaran Dibuat',
                        'status_diubah' => 'Status Diubah',
                        'dokumen_diunggah' => 'Dokumen Diunggah',
                        'dokumen_diverifikasi' => 'Dokumen Diverifikasi',
                    ]),
            ])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
