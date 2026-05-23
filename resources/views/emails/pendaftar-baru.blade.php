@component('mail::message')
# Pendaftaran Anda Tercatat

Halo **{{ $pendaftar->nama_lengkap }}**,

Terima kasih telah mendaftar di **{{ $pendaftar->sekolah?->nama ?? $pendaftar->sekolah_tujuan }}** melalui platform SPMB.

**Detail Pendaftaran:**

| Item | Nilai |
|------|-------|
| Nomor Pendaftaran | `{{ $pendaftar->nomor_pendaftaran }}` |
| Sekolah Tujuan | {{ $pendaftar->sekolah?->nama ?? $pendaftar->sekolah_tujuan }} |
| Jalur | {{ ucfirst($pendaftar->jalur_pendaftaran) }} |
| Tanggal Daftar | {{ $pendaftar->created_at->translatedFormat('d F Y, H:i') }} |

Simpan nomor pendaftaran Anda dengan baik. Anda akan membutuhkannya untuk verifikasi dokumen dan pengumuman hasil seleksi.

@component('mail::button', ['url' => route('portal'), 'color' => 'primary'])
Buka Portal Pendaftar
@endcomponent

**Langkah selanjutnya:**
1. Lengkapi dokumen persyaratan di portal
2. Tim sekolah akan memverifikasi data Anda dalam 1–3 hari kerja
3. Pengumuman dikirim via email dan dapat dicek di portal

Salam,<br>
**Tim SPMB {{ config('app.name') }}**
@endcomponent
