<?php

use App\Http\Controllers\PortalController;
use App\Http\Controllers\SekolahController;
use App\Models\Pendaftar;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'totalPendaftar' => Pendaftar::count(),
        'totalSekolah' => Sekolah::where('is_active', true)->count(),
        'diterima' => Pendaftar::where('status', 'diterima')->count(),
        'verifikasi' => Pendaftar::where('status', 'verifikasi')->count(),
        'sekolahPreview' => Sekolah::where('is_active', true)->orderBy('nama')->limit(6)->get(),
    ]);
})->name('home');

Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
Route::get('/sekolah/register', fn () => view('sekolah-register'))->name('sekolah.register');
Route::get('/sekolah/{sekolah:slug}', [SekolahController::class, 'show'])->name('sekolah.show');
Route::get('/sekolah/{sekolah:slug}/rekomendasi', [SekolahController::class, 'rekomendasi'])->name('sekolah.rekomendasi');

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::view('/login', 'auth.login')->name('login');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/portal', [PortalController::class, 'index'])->name('portal');
    Route::get('/portal/dokumen', [PortalController::class, 'dokumen'])->name('portal.dokumen');
    Route::get('/portal/dokumen/{dokumen}/preview', [PortalController::class, 'previewDokumen'])->name('portal.dokumen.preview');

    Route::get('/sekolah/{sekolah:slug}/daftar', [SekolahController::class, 'daftar'])->name('sekolah.daftar');

    Route::get('/daftar/sukses/{nomor}', function (string $nomor) {
        $pendaftar = Pendaftar::where('nomor_pendaftaran', $nomor)->firstOrFail();
        return view('daftar-sukses', ['nomor' => $pendaftar->nomor_pendaftaran]);
    })->name('daftar.sukses');
});
