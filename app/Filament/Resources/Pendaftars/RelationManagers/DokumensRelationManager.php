<?php

namespace App\Filament\Resources\Pendaftars\RelationManagers;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DokumensRelationManager extends RelationManager
{
    protected static string $relationship = 'dokumens';

    protected static ?string $title = 'Dokumen Pendaftar';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('catatan_verifikasi')
                    ->label('Catatan Verifikasi')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->columns([
                TextColumn::make('label')
                    ->label('Dokumen')
                    ->weight('semibold'),
                TextColumn::make('original_name')
                    ->label('File')
                    ->limit(28)
                    ->color('gray')
                    ->size('sm'),
                TextColumn::make('size_formatted')
                    ->label('Ukuran')
                    ->color('gray')
                    ->size('sm'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => ucfirst($state ?? '-'))
                    ->color(fn (?string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('verified_at')
                    ->label('Diverifikasi')
                    ->dateTime('d M Y H:i')
                    ->placeholder('—')
                    ->size('sm'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ]),
            ])
            ->headerActions([])
            ->recordActions([
                Action::make('preview')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->color('gray')
                    ->url(fn (Model $record): string => route('portal.dokumen.preview', ['dokumen' => $record->id]))
                    ->openUrlInNewTab(),
                Action::make('terima')
                    ->label('Terima')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->visible(fn (Model $record): bool => $record->status !== 'diterima')
                    ->requiresConfirmation()
                    ->action(function (Model $record): void {
                        $record->update([
                            'status' => 'diterima',
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                            'catatan_verifikasi' => null,
                        ]);
                        Notification::make()->title('Dokumen diterima')->success()->send();
                    }),
                Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->visible(fn (Model $record): bool => $record->status !== 'ditolak')
                    ->schema([
                        Textarea::make('catatan_verifikasi')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Model $record, array $data): void {
                        $record->update([
                            'status' => 'ditolak',
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                            'catatan_verifikasi' => $data['catatan_verifikasi'],
                        ]);
                        Notification::make()->title('Dokumen ditolak')->warning()->send();
                    }),
            ])
            ->toolbarActions([]);
    }
}
