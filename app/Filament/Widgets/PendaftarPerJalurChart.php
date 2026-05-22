<?php

namespace App\Filament\Widgets;

use App\Models\Pendaftar;
use Filament\Widgets\ChartWidget;

class PendaftarPerJalurChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Pendaftar per Jalur';

    protected ?string $pollingInterval = '60s';

    protected function getData(): array
    {
        $query = Pendaftar::query()
            ->selectRaw('jalur_pendaftaran, COUNT(*) as total')
            ->groupBy('jalur_pendaftaran');

        $user = auth()->user();
        if ($user && $user->isSekolahAdmin() && $user->sekolah_id) {
            $query->where('sekolah_id', $user->sekolah_id);
        }

        $data = $query->get();

        return [
            'datasets' => [
                [
                    'label' => 'Pendaftar',
                    'data' => $data->pluck('total')->all(),
                    'backgroundColor' => [
                        '#6b7280',
                        '#10b981',
                        '#f59e0b',
                        '#3b82f6',
                    ],
                ],
            ],
            'labels' => $data->pluck('jalur_pendaftaran')
                ->map(fn (string $j): string => ucfirst($j))
                ->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
