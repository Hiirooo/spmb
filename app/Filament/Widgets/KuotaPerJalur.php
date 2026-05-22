<?php

namespace App\Filament\Widgets;

use App\Models\Pendaftar;
use App\Models\Sekolah;
use App\Support\SpmbDokumen;
use Filament\Widgets\Widget;

class KuotaPerJalur extends Widget
{
    protected static bool $isLazy = false;

    protected string $view = 'filament.widgets.kuota-per-jalur';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->isSekolahAdmin() ?? false;
    }

    public function getViewData(): array
    {
        $user = auth()->user();
        $sekolah = $user?->sekolah;

        if (! $sekolah) {
            return ['stats' => [], 'sekolah' => null, 'totalPendaftar' => 0];
        }

        $kuotaJalur = $sekolah->kuota_jalur ?? Sekolah::defaultKuota();
        $stats = [];
        $totalKuota = 0;
        $totalTerisi = 0;

        foreach (SpmbDokumen::JALUR as $key => $label) {
            $persentase = $kuotaJalur[$key] ?? 0;
            $kuota = (int) round(($sekolah->daya_tampung_total * $persentase) / 100);
            $terisi = Pendaftar::where('sekolah_id', $sekolah->id)
                ->where('jalur_pendaftaran', $key)
                ->whereIn('status', ['baru', 'verifikasi', 'diterima', 'cadangan'])
                ->count();
            $diterima = Pendaftar::where('sekolah_id', $sekolah->id)
                ->where('jalur_pendaftaran', $key)
                ->where('status', 'diterima')
                ->count();
            $persen = $kuota > 0 ? (int) round($terisi / $kuota * 100) : 0;

            $stats[$key] = [
                'label' => $label,
                'persentase' => $persentase,
                'kuota' => $kuota,
                'terisi' => $terisi,
                'diterima' => $diterima,
                'persen' => $persen,
                'sisa' => max(0, $kuota - $terisi),
                'penuh' => $persen >= 100,
            ];
            $totalKuota += $kuota;
            $totalTerisi += $terisi;
        }

        return [
            'stats' => $stats,
            'sekolah' => $sekolah,
            'totalKuota' => $totalKuota,
            'totalTerisi' => $totalTerisi,
            'totalPendaftar' => Pendaftar::where('sekolah_id', $sekolah->id)->count(),
        ];
    }
}
