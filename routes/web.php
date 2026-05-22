<?php

use App\Http\Controllers\PortalController;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'totalPendaftar' => Pendaftar::count(),
        'diterima' => Pendaftar::where('status', 'diterima')->count(),
        'verifikasi' => Pendaftar::where('status', 'verifikasi')->count(),
    ]);
})->name('home');

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

    Route::get('/daftar', function () {
        $user = Auth::user();
        if ($user->pendaftar) {
            return redirect()->route('portal');
        }
        return view('daftar');
    })->name('daftar');

    Route::get('/daftar/sukses/{nomor}', function (string $nomor) {
        $pendaftar = Pendaftar::where('nomor_pendaftaran', $nomor)->firstOrFail();
        return view('daftar-sukses', ['nomor' => $pendaftar->nomor_pendaftaran]);
    })->name('daftar.sukses');
});
