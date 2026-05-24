<?php

use App\Http\Controllers\Api\ReferenceLookupController;
use Illuminate\Support\Facades\Route;

Route::prefix('referensi')->group(function () {
    Route::get('/siswa', [ReferenceLookupController::class, 'siswaByNisnQuery']);
    Route::get('/siswa/{nisn}', [ReferenceLookupController::class, 'siswaByNisn'])
        ->whereNumber('nisn');

    Route::get('/sekolah', [ReferenceLookupController::class, 'sekolahByNpsnQuery']);
    Route::get('/sekolah/{npsn}', [ReferenceLookupController::class, 'sekolahByNpsn'])
        ->whereNumber('npsn');
});
