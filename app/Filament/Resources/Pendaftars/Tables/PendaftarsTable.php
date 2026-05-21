<?php

namespace App\Filament\Resources\Pendaftars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PendaftarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('program_studi')
                    ->label('Prodi')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('jalur_pendaftaran')
                    ->label('Jalur')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'reguler' => 'gray',
                        'prestasi' => 'success',
                        'beasiswa' => 'warning',
                        'transfer' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->searchable()
                    ->limit(30)
                    ->toggleable(),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('no_telepon')
                    ->label('Telepon')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'baru' => 'gray',
                        'verifikasi' => 'warning',
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                        'cadangan' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Daftar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'baru' => 'Baru',
                        'verifikasi' => 'Verifikasi',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                        'cadangan' => 'Cadangan',
                    ]),
                SelectFilter::make('jalur_pendaftaran')
                    ->label('Jalur')
                    ->options([
                        'reguler' => 'Reguler',
                        'prestasi' => 'Prestasi',
                        'beasiswa' => 'Beasiswa',
                        'transfer' => 'Transfer',
                    ]),
                SelectFilter::make('program_studi')
                    ->label('Program Studi')
                    ->options(fn (): array => \App\Models\Pendaftar::query()
                        ->distinct()
                        ->pluck('program_studi', 'program_studi')
                        ->all()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
