@php $diterima = $dokumen->status === 'diterima'; @endphp
@component('mail::message')
# Dokumen {{ $diterima ? 'Diterima' : 'Ditolak' }}

Halo **{{ $pendaftar->nama_lengkap }}**,

Dokumen **{{ $dokumen->label }}** untuk pendaftaran `{{ $pendaftar->nomor_pendaftaran }}` telah {{ $diterima ? 'diverifikasi dan diterima' : 'ditolak' }} oleh tim sekolah.

@if(! $diterima && $dokumen->catatan_verifikasi)
**Catatan dari panitia:**

> {{ $dokumen->catatan_verifikasi }}

Silakan unggah ulang dokumen yang sesuai persyaratan.
@endif

@component('mail::button', ['url' => route('portal.dokumen'), 'color' => $diterima ? 'success' : 'error'])
{{ $diterima ? 'Lihat Status Dokumen' : 'Unggah Ulang' }}
@endcomponent

Salam,<br>
**Tim SPMB {{ config('app.name') }}**
@endcomponent
