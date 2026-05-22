<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Services\JalurRecommender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        $query = Sekolah::query()->where('is_active', true);

        if ($search = $request->string('q')->toString()) {
            $query->where(fn ($q) => $q
                ->where('nama', 'like', "%{$search}%")
                ->orWhere('npsn', 'like', "%{$search}%")
                ->orWhere('kabupaten_kota', 'like', "%{$search}%"));
        }

        $kabupaten = $request->string('kab')->toString();
        if ($kabupaten) {
            $query->where('kabupaten_kota', $kabupaten);
        }

        $sekolahs = $query->orderBy('nama')->paginate(12)->withQueryString();
        $kabupatens = Sekolah::query()->where('is_active', true)
            ->select('kabupaten_kota')->distinct()->orderBy('kabupaten_kota')
            ->pluck('kabupaten_kota');

        return view('sekolah-index', [
            'sekolahs' => $sekolahs,
            'kabupatens' => $kabupatens,
            'q' => $search,
            'kab' => $kabupaten,
        ]);
    }

    public function show(Sekolah $sekolah)
    {
        abort_unless($sekolah->is_active, 404);

        $totalPendaftar = $sekolah->pendaftars()->count();
        $kuotaJalur = $sekolah->kuota_jalur ?? Sekolah::defaultKuota();
        $stats = [];
        foreach (\App\Support\SpmbDokumen::JALUR as $key => $label) {
            $persentase = $kuotaJalur[$key] ?? 0;
            $kuota = (int) round(($sekolah->daya_tampung_total * $persentase) / 100);
            $terisi = $sekolah->getKuotaTerisi($key);
            $stats[$key] = [
                'label' => $label,
                'persentase' => $persentase,
                'kuota' => $kuota,
                'terisi' => $terisi,
                'persen_terisi' => $kuota > 0 ? (int) round($terisi / $kuota * 100) : 0,
            ];
        }

        return view('sekolah-show', [
            'sekolah' => $sekolah,
            'totalPendaftar' => $totalPendaftar,
            'stats' => $stats,
        ]);
    }

    public function rekomendasi(Sekolah $sekolah)
    {
        abort_unless($sekolah->is_active, 404);
        return view('sekolah-rekomendasi', ['sekolah' => $sekolah]);
    }

    public function daftar(Request $request, Sekolah $sekolah)
    {
        abort_unless($sekolah->is_active && $sekolah->is_pendaftaran_buka, 403, 'Pendaftaran sekolah ini sedang ditutup.');

        $user = Auth::user();
        if ($user->pendaftar) {
            return redirect()->route('portal');
        }

        $jalur = $request->string('jalur')->toString()
            ?: session()->get('jalur_rekomendasi.'.$sekolah->slug);

        return view('sekolah-daftar', [
            'sekolah' => $sekolah,
            'jalur' => $jalur,
        ]);
    }
}
