<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Pendaftars\PendaftarResource;
use App\Models\Pendaftar;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestPendaftar extends TableWidget
{
    protected static ?string $heading = 'Pendaftar Terbaru';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                $query = Pendaftar::query()->latest()->limit(5);
                $user = auth()->user();
                if ($user && $user->isSekolahAdmin() && $user->sekolah_id) {
                    $query->where('sekolah_id', $user->sekolah_id);
                }
                return $query;
            })
            ->paginated(false)
            ->columns([
                TextColumn::make('nomor_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->copyable(),
                TextColumn::make('nama_lengkap')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('sekolah_tujuan')
                    ->label('Sekolah Tujuan')
                    ->badge()
                    ->color('info'),
                TextColumn::make('jalur_pendaftaran')
                    ->label('Jalur')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
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
                    ->dateTime('d M Y H:i'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Pendaftar $record): string => PendaftarResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
