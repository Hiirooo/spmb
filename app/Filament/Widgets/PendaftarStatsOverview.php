<?php

namespace App\Filament\Widgets;

use App\Models\Pendaftar;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PendaftarStatsOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $query = $this->scopedQuery();

        $total = (clone $query)->count();
        $baru = (clone $query)->where('status', 'baru')->count();
        $verifikasi = (clone $query)->where('status', 'verifikasi')->count();
        $diterima = (clone $query)->where('status', 'diterima')->count();
        $ditolak = (clone $query)->where('status', 'ditolak')->count();

        return [
            Stat::make('Total Pendaftar', $total)
                ->description('Seluruh pendaftaran masuk')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Belum Diverifikasi', $baru)
                ->description('Menunggu verifikasi admin')
                ->descriptionIcon('heroicon-m-clock')
                ->color('gray'),

            Stat::make('Sedang Diverifikasi', $verifikasi)
                ->description('Dalam proses verifikasi')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color('warning'),

            Stat::make('Diterima', $diterima)
                ->description('Calon mahasiswa lulus seleksi')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Ditolak', $ditolak)
                ->description('Tidak lulus seleksi')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }

    protected function scopedQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = Pendaftar::query();
        $user = auth()->user();
        if ($user && $user->isSekolahAdmin() && $user->sekolah_id) {
            $query->where('sekolah_id', $user->sekolah_id);
        }
        return $query;
    }
}
