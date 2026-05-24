# SPMB

SPMB adalah aplikasi Laravel untuk mengelola Sistem Penerimaan Murid Baru. Aplikasi ini menyediakan portal pendaftaran siswa, registrasi sekolah, rekomendasi jalur, unggah dokumen, pengumuman hasil seleksi, dan panel admin berbasis Filament.

## Fitur Utama

- Portal publik untuk melihat sekolah aktif dan status pendaftaran.
- Registrasi akun siswa dengan NISN.
- Registrasi sekolah dengan NPSN dan akun admin sekolah.
- Form pendaftaran siswa per sekolah tujuan.
- Jalur pendaftaran: afirmasi, domisili, mutasi, dan prestasi.
- Rekomendasi jalur berdasarkan data pendaftar.
- Upload dan preview dokumen pendaftaran.
- Portal siswa untuk melihat status dan melengkapi berkas.
- Pengumuman siswa diterima per sekolah.
- Panel admin Filament untuk mengelola sekolah, pendaftar, status seleksi, dan ekspor Excel.
- Generate dokumen PDF dengan DomPDF.

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

Pakai SQLite default:

```bash
touch database/database.sqlite
php artisan migrate
```

Atau ubah konfigurasi database di `.env` jika memakai MySQL:

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
| `/register` | Registrasi akun siswa |
| `/login` | Login siswa/admin |
| `/portal` | Portal siswa |
| `/portal/dokumen` | Upload dokumen pendaftaran |
| `/cek-status` | Cek status pendaftaran |
| `/pengumuman` | Pengumuman hasil seleksi |
| `/admin` | Panel admin Filament |

## Alur Penggunaan

1. Admin/sekolah mendaftarkan sekolah melalui `/sekolah/register` atau panel admin.
2. Siswa membuat akun melalui `/register`.
3. Siswa memilih sekolah tujuan dari halaman `/sekolah`.
4. Siswa mengisi formulir pendaftaran dan memilih jalur.
5. Siswa mengunggah dokumen melalui portal.
6. Admin memverifikasi data, mengubah status, dan mengelola hasil seleksi.
7. Hasil dapat dilihat melalui halaman pengumuman.

## Data Penting

- `users`: akun siswa, admin sekolah, dan admin sistem.
- `sekolahs`: data sekolah, NPSN, kuota, status pendaftaran, koordinat, dan kontak.
- `pendaftars`: data pendaftaran siswa, NISN, NIK, jalur, dan status.
- `pendaftar_dokumens`: dokumen persyaratan pendaftar.
- `pendaftar_logs`: riwayat perubahan status pendaftar.

## Perintah Berguna

```bash
php artisan migrate
php artisan route:list
php artisan test
npm run build
```

## Catatan NISN dan NPSN

Aplikasi menyimpan NISN siswa dan NPSN sekolah untuk kebutuhan pendaftaran. Validasi data resmi nasional dari Kemendikdasmen memerlukan akses resmi Pusdatin/Backbone atau input manual dari sekolah/dinas. Jangan melakukan scraping otomatis ke layanan NISN resmi karena layanan tersebut menggunakan captcha dan memuat data pribadi siswa.

## Lisensi

Project ini berbasis Laravel dan mengikuti lisensi MIT.
