<?php

namespace App\Filament\Resources\Pendaftars\Tables;

use App\Support\SpmbDokumen;
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
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->searchable()
                    ->limit(28)
                    ->toggleable(),
                TextColumn::make('sekolah_tujuan')
                    ->label('Sekolah Tujuan')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('jalur_pendaftaran')
                    ->label('Jalur')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'afirmasi' => 'success',
                        'domisili' => 'gray',
                        'mutasi' => 'warning',
                        'prestasi' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('dokumens_count')
                    ->label('Berkas')
                    ->counts('dokumens')
                    ->badge()
                    ->color('gray'),
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
                    ->options(SpmbDokumen::JALUR),
                SelectFilter::make('sekolah_tujuan')
                    ->label('Sekolah Tujuan')
                    ->options(fn (): array => \App\Models\Pendaftar::query()
                        ->distinct()
                        ->pluck('sekolah_tujuan', 'sekolah_tujuan')
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
