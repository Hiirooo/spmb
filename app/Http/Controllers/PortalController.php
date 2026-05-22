<?php

namespace App\Http\Controllers;

use App\Models\PendaftarDokumen;
use App\Support\SpmbDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PortalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $pendaftar = $user->pendaftar;

        $progress = null;
        if ($pendaftar) {
            $required = SpmbDokumen::requiredForJalur($pendaftar->jalur_pendaftaran);
            $wajib = collect($required)->reject(fn ($r) => SpmbDokumen::isOptional($r['jenis'], $pendaftar->jalur_pendaftaran));
            $uploaded = $pendaftar->dokumens()->whereIn('jenis', $wajib->pluck('jenis'))->count();
            $progress = [
                'total' => $wajib->count(),
                'uploaded' => $uploaded,
                'percent' => $wajib->count() > 0 ? (int) round(($uploaded / $wajib->count()) * 100) : 0,
            ];
        }

        return view('portal', [
            'user' => $user,
            'pendaftar' => $pendaftar,
            'progress' => $progress,
        ]);
    }

    public function dokumen(Request $request)
    {
        $pendaftar = $request->user()->pendaftar;
        abort_unless($pendaftar, 403, 'Anda belum mendaftar.');

        return view('portal-dokumen', [
            'pendaftar' => $pendaftar,
        ]);
    }

    public function previewDokumen(Request $request, PendaftarDokumen $dokumen): StreamedResponse
    {
        $user = $request->user();
        abort_unless(
            $user->isAdmin() || $dokumen->pendaftar->user_id === $user->id,
            403
        );

        return Storage::disk('local')->response(
            $dokumen->path,
            $dokumen->original_name,
            ['Content-Type' => $dokumen->mime_type],
            'inline'
        );
    }
}
