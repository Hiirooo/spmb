<?php

namespace App\Filament\Widgets;

use App\Models\Pendaftar;
use Filament\Widgets\ChartWidget;

class PendaftarPerProdiChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Pendaftar per Program Studi';

    protected ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Pendaftar::query()
            ->selectRaw('program_studi, COUNT(*) as total')
            ->groupBy('program_studi')
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pendaftar',
                    'data' => $data->pluck('total')->all(),
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#1d4ed8',
                ],
            ],
            'labels' => $data->pluck('program_studi')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
