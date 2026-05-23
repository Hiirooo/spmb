@php
$labels = [
    'baru' => 'Pendaftaran Baru',
    'verifikasi' => 'Sedang Diverifikasi',
    'diterima' => 'Diterima',
    'ditolak' => 'Tidak Diterima',
    'cadangan' => 'Cadangan',
];
$current = $labels[$pendaftar->status] ?? ucfirst($pendaftar->status);
$prev = $labels[$statusLama] ?? ucfirst($statusLama);
@endphp
@component('mail::message')
# Status Pendaftaran Anda Berubah

Halo **{{ $pendaftar->nama_lengkap }}**,

Status pendaftaran `{{ $pendaftar->nomor_pendaftaran }}` di **{{ $pendaftar->sekolah?->nama ?? $pendaftar->sekolah_tujuan }}** telah diperbarui.

| Sebelumnya | Sekarang |
|------------|----------|
| {{ $prev }} | **{{ $current }}** |

@if($pendaftar->status === 'diterima')
**Selamat!** Anda dinyatakan diterima sebagai calon murid baru. Silakan tunggu informasi lanjutan untuk daftar ulang.
@elseif($pendaftar->status === 'ditolak')
Mohon maaf, Anda belum diterima pada periode ini.
@elseif($pendaftar->status === 'cadangan')
Anda masuk daftar cadangan. Pengumuman lanjutan akan dikirim apabila ada kursi yang tersedia.
@endif

@if($pendaftar->catatan)
**Catatan dari panitia:**

> {{ $pendaftar->catatan }}
@endif

@component('mail::button', ['url' => route('portal'), 'color' => 'primary'])
Buka Portal
@endcomponent

Salam,<br>
**Tim SPMB {{ config('app.name') }}**
@endcomponent
