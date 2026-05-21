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
        $total = Pendaftar::count();
        $baru = Pendaftar::where('status', 'baru')->count();
        $verifikasi = Pendaftar::where('status', 'verifikasi')->count();
        $diterima = Pendaftar::where('status', 'diterima')->count();
        $ditolak = Pendaftar::where('status', 'ditolak')->count();

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
}
