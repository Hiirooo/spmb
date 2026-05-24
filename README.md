# SPMB

SPMB adalah aplikasi web berbasis Laravel untuk mengelola Sistem Penerimaan Murid Baru secara terpusat. Sistem ini membantu sekolah, panitia, dan calon murid dalam proses pendaftaran, verifikasi dokumen, seleksi jalur, pengumuman, dan pelaporan data pendaftar.

## Ringkasan

SPMB dirancang untuk mendukung proses penerimaan murid baru dengan alur digital dari awal sampai akhir:

1. Sekolah mendaftarkan profil dan kuota pendaftaran.
2. Calon murid membuat akun dan memilih sekolah tujuan.
3. Calon murid mengisi formulir pendaftaran sesuai jalur.
4. Calon murid mengunggah dokumen persyaratan.
5. Admin sekolah/panitia memverifikasi data dan dokumen.
6. Sistem mencatat perubahan status dan menyediakan pengumuman hasil.
7. Data pendaftar dapat dipantau melalui dashboard dan diekspor ke Excel.

## Fitur Utama

### Portal Publik

- Beranda dengan statistik pendaftar dan sekolah aktif.
- Daftar sekolah dengan pencarian nama, NPSN, dan kabupaten/kota.
- Detail sekolah berisi profil, kontak, status pendaftaran, dan kuota jalur.
- Halaman pengumuman hasil seleksi per sekolah.
- Cek status pendaftaran menggunakan nomor pendaftaran dan NIK.

### Pendaftaran Calon Murid

- Registrasi akun calon murid dengan email dan NISN.
- Login menggunakan email atau NISN.
- Formulir pendaftaran lengkap: identitas, NIK, NISN, tempat/tanggal lahir, alamat, data orang tua, asal sekolah, dan jalur pendaftaran.
- Validasi NISN 10 digit dan NIK 16 digit.
- Nomor pendaftaran otomatis berdasarkan sekolah dan tahun pendaftaran.
- Pencegahan pendaftaran ganda untuk satu akun.

### Jalur Pendaftaran

- Afirmasi.
- Domisili.
- Mutasi.
- Prestasi.
- Rekomendasi jalur berdasarkan jawaban calon murid.
- Perhitungan jarak rumah ke sekolah menggunakan alamat atau koordinat.
- Validasi kuota jalur agar calon murid tidak memilih jalur yang sudah penuh.

### Dokumen Pendaftaran

- Upload dokumen per jalur pendaftaran.
- Format dokumen: PDF, JPG, JPEG, PNG.
- Batas ukuran file: 2 MB.
- Preview dokumen oleh siswa dan admin.
- Hapus dan upload ulang dokumen.
- Validasi kelengkapan dokumen wajib per jalur.
- Generate PDF pakta integritas.

### Panel Admin

- Panel admin berbasis Filament.
- Manajemen pendaftar dan status seleksi.
- Manajemen sekolah oleh super admin.
- Pengaturan sekolah oleh admin sekolah.
- Verifikasi dokumen: terima/tolak dengan catatan.
- Riwayat aktivitas pendaftar.
- Export data pendaftar ke Excel.
- Dashboard statistik dan grafik.

### Notifikasi

- Email pendaftaran baru.
- Email perubahan status pendaftaran.
- Template email verifikasi dokumen.

## Tech Stack

- PHP ^8.3
- Laravel ^13.8
- Filament ^4.0
- Livewire
- Tailwind CSS ^4.0
- Vite ^8.0
- SQLite/MySQL
- DomPDF
- OpenSpout

## Kebutuhan Sistem

- PHP 8.3 atau lebih baru
- Composer
- Node.js dan npm
- SQLite atau MySQL

## Instalasi Lokal

```bash
git clone https://github.com/Hiirooo/spmb.git
cd spmb
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### Opsi SQLite

```bash
touch database/database.sqlite
php artisan migrate
```

### Opsi MySQL

Ubah konfigurasi database di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spmb
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan migrasi:

```bash
php artisan migrate
```

## Menjalankan Aplikasi

Mode development lengkap:

```bash
composer run dev
```

Atau jalankan backend dan frontend terpisah:

```bash
php artisan serve
npm run dev
```

Build asset production:

```bash
npm run build
```

## Route Penting

| Route | Keterangan |
| --- | --- |
| `/` | Beranda dan ringkasan statistik |
| `/sekolah` | Daftar sekolah aktif |
| `/sekolah/register` | Registrasi sekolah dan admin sekolah |
| `/register` | Registrasi akun calon murid |
| `/login` | Login siswa/admin |
| `/portal` | Portal siswa |
| `/portal/dokumen` | Upload dokumen pendaftaran |
| `/cek-status` | Cek status pendaftaran |
| `/pengumuman` | Pengumuman hasil seleksi |
| `/admin` | Panel admin Filament |

## Dokumentasi

- [Daftar Fitur](docs/FITUR.md)
- [Panduan SMTP](docs/SMTP.md)

## Data Utama

| Tabel | Fungsi |
| --- | --- |
| `users` | Akun siswa, admin sekolah, dan super admin |
| `sekolahs` | Profil sekolah, NPSN, kuota, koordinat, dan status pendaftaran |
| `pendaftars` | Data pendaftaran calon murid, jalur, dan status seleksi |
| `pendaftar_dokumens` | Dokumen persyaratan pendaftaran |
| `pendaftar_logs` | Riwayat aktivitas dan perubahan status |

## Perintah Berguna

```bash
php artisan migrate
php artisan route:list
php artisan test
npm run build
```

## Catatan NISN dan NPSN

Aplikasi menyimpan NISN siswa dan NPSN sekolah untuk kebutuhan pendaftaran. Validasi data resmi nasional dari Kemendikdasmen memerlukan akses resmi Pusdatin/Backbone atau input manual dari sekolah/dinas.

Hindari scraping otomatis ke layanan NISN resmi karena layanan tersebut menggunakan captcha dan memuat data pribadi siswa.

## Roadmap Singkat

- Ranking otomatis per jalur.
- Import data awal siswa dari sekolah/dinas.
- Kartu pendaftaran dengan QR Code.
- Notifikasi WhatsApp.
- Manajemen periode dan gelombang pendaftaran.
- Bulk action untuk verifikasi dan seleksi.

## Lisensi

Project ini berbasis Laravel dan mengikuti lisensi MIT.
