<?php

namespace App\Filament\Widgets;

use App\Models\Pendaftar;
use Filament\Widgets\ChartWidget;

class PendaftarPerProdiChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Pendaftar per Sekolah Tujuan';

    protected ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $query = Pendaftar::query()
            ->selectRaw('sekolah_tujuan, COUNT(*) as total')
            ->groupBy('sekolah_tujuan')
            ->orderByDesc('total');

        $user = auth()->user();
        if ($user && $user->isSekolahAdmin() && $user->sekolah_id) {
            $query->where('sekolah_id', $user->sekolah_id);
        }

        $data = $query->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pendaftar',
                    'data' => $data->pluck('total')->all(),
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#1d4ed8',
                ],
            ],
            'labels' => $data->pluck('sekolah_tujuan')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
