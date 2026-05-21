<?php

use App\Models\Pendaftar;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'totalPendaftar' => Pendaftar::count(),
        'diterima' => Pendaftar::where('status', 'diterima')->count(),
        'verifikasi' => Pendaftar::where('status', 'verifikasi')->count(),
    ]);
})->name('home');

Route::get('/daftar', fn () => view('daftar'))->name('daftar');

Route::get('/daftar/sukses/{nomor}', function (string $nomor) {
    $pendaftar = Pendaftar::where('nomor_pendaftaran', $nomor)->firstOrFail();

    return view('daftar-sukses', ['nomor' => $pendaftar->nomor_pendaftaran]);
})->name('daftar.sukses');
