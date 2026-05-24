# Daftar Fitur SPMB

Dokumen ini merangkum fitur yang sudah tersedia dan area pengembangan lanjutan untuk aplikasi SPMB.

## 1. Portal Publik

### Beranda

Status: tersedia

Fungsi:

- Menampilkan ringkasan jumlah pendaftar.
- Menampilkan jumlah sekolah aktif.
- Menampilkan jumlah pendaftar diterima.
- Menampilkan jumlah pendaftar dalam proses verifikasi.
- Menampilkan preview sekolah aktif.

Manfaat:

- Memberikan gambaran cepat kepada pengunjung.
- Memperkuat transparansi proses penerimaan.

### Daftar Sekolah

Status: tersedia

Fungsi:

- Menampilkan sekolah aktif.
- Pencarian berdasarkan nama sekolah, NPSN, dan kabupaten/kota.
- Filter berdasarkan kabupaten/kota.
- Pagination.

Manfaat:

- Memudahkan calon murid menemukan sekolah tujuan.
- Memudahkan pencarian sekolah berdasarkan wilayah.

### Detail Sekolah

Status: tersedia

Fungsi:

- Menampilkan profil sekolah.
- Menampilkan kontak sekolah.
- Menampilkan daya tampung.
- Menampilkan statistik kuota per jalur.
- Menampilkan jumlah pendaftar.

Manfaat:

- Calon murid dapat melihat informasi penting sebelum mendaftar.
- Sekolah dapat menampilkan kapasitas dan status penerimaan secara terbuka.

### Pengumuman Hasil Seleksi

Status: tersedia

Fungsi:

- Menampilkan daftar sekolah yang memiliki pendaftar diterima.
- Menampilkan daftar pendaftar diterima per sekolah.
- Filter pengumuman berdasarkan jalur.
- Pencarian berdasarkan nama, nomor pendaftaran, atau NISN.

Manfaat:

- Pengumuman dapat diakses publik secara terstruktur.
- Siswa tidak perlu datang langsung ke sekolah untuk melihat hasil.

### Cek Status Pendaftaran

Status: tersedia

Fungsi:

- Cek status menggunakan nomor pendaftaran dan NIK.
- Rate limit untuk mencegah percobaan berlebihan.
- Menampilkan status pendaftaran dan dokumen terkait.

Manfaat:

- Calon murid dapat memantau proses pendaftaran tanpa login.
- Data sensitif tetap dilindungi dengan kombinasi nomor pendaftaran dan NIK.

## 2. Akun dan Autentikasi

### Registrasi Calon Murid

Status: tersedia

Fungsi:

- Registrasi akun calon murid.
- Input nama, email, NISN, dan password.
- Validasi email unik.
- Validasi NISN 10 digit.
- Login otomatis setelah registrasi.

Manfaat:

- Calon murid dapat langsung melanjutkan proses pendaftaran setelah membuat akun.

### Login Email atau NISN

Status: tersedia

Fungsi:

- Login menggunakan email atau NISN.
- Validasi password.
- Rate limit login.
- Redirect otomatis berdasarkan role.

Manfaat:

- Memudahkan siswa yang lebih sering mengingat NISN daripada email.
- Mengurangi risiko brute force login.

### Role Pengguna

Status: tersedia

Role:

- `super_admin`
- `sekolah_admin`
- `pendaftar`

Manfaat:

- Hak akses dapat dipisahkan antara admin pusat, admin sekolah, dan calon murid.

## 3. Pendaftaran Calon Murid

### Form Pendaftaran

Status: tersedia

Data yang dikelola:

- Nama lengkap.
- NISN.
- NIK.
- Jenis kelamin.
- Tempat dan tanggal lahir.
- Alamat.
- Data ayah/ibu.
- Pekerjaan dan penghasilan orang tua.
- Email dan nomor telepon.
- Asal sekolah.
- Tahun lulus.
- Sekolah tujuan.
- Jalur pendaftaran.
- Data prestasi jika memilih jalur prestasi.

Manfaat:

- Form pendaftaran sudah mencakup data utama yang umum dibutuhkan dalam proses SPMB.

### Nomor Pendaftaran Otomatis

Status: tersedia

Fungsi:

- Membuat nomor pendaftaran saat data pendaftar dibuat.
- Menggunakan prefix sekolah, tahun, dan nomor urut.
- Menjaga nomor tetap unik per sekolah dan tahun.

Manfaat:

- Panitia tidak perlu membuat nomor pendaftaran manual.
- Nomor pendaftaran lebih mudah dilacak.

### Pencegahan Pendaftaran Ganda

Status: tersedia

Fungsi:

- Jika akun sudah memiliki data pendaftar, user diarahkan ke portal.

Manfaat:

- Mengurangi risiko satu akun membuat banyak pendaftaran.

## 4. Jalur Pendaftaran dan Kuota

### Jalur Pendaftaran

Status: tersedia

Jalur:

- Afirmasi.
- Domisili.
- Mutasi.
- Prestasi.

### Kuota Per Jalur

Status: tersedia

Fungsi:

- Set persentase kuota per jalur.
- Validasi total kuota harus 100%.
- Hitung kuota berdasarkan daya tampung sekolah.
- Cek jalur penuh saat calon murid mendaftar.

Manfaat:

- Sekolah dapat mengelola daya tampung dengan lebih tertib.
- Calon murid tidak memilih jalur yang sudah penuh.

### Rekomendasi Jalur

Status: tersedia

Fungsi:

- Kuesioner untuk menentukan jalur paling sesuai.
- Penilaian berdasarkan bantuan sosial, penghasilan, disabilitas, domisili, jarak, mutasi orang tua, anak guru, nilai rapor, prestasi, dan TKA.
- Menampilkan skor dan alasan rekomendasi.

Manfaat:

- Membantu calon murid memilih jalur yang paling relevan.
- Mengurangi kebingungan saat memilih jalur pendaftaran.

### Hitung Jarak ke Sekolah

Status: tersedia

Fungsi:

- Input alamat lengkap atau koordinat.
- Geocoding alamat.
- Hitung jarak ke koordinat sekolah.

Manfaat:

- Mendukung kebutuhan jalur domisili.
- Memberikan estimasi jarak secara cepat.

## 5. Dokumen Pendaftaran

### Upload Dokumen

Status: tersedia

Fungsi:

- Upload dokumen berdasarkan jalur.
- Format file: PDF, JPG, JPEG, PNG.
- Maksimum ukuran file: 2 MB.
- Upload ulang dokumen.
- Hapus dokumen.

### Syarat Dokumen Per Jalur

Status: tersedia

Dokumen umum:

- Kartu Keluarga.
- Akta Kelahiran.
- Ijazah atau Surat Keterangan Lulus.
- Rapor 5 semester.
- Pas foto.
- Pakta integritas.

Dokumen afirmasi:

- KIP/KKS/PKH.
- SKTM.
- Surat keterangan disabilitas.

Dokumen domisili:

- Surat keterangan domisili.

Dokumen mutasi:

- SK mutasi orang tua.
- SK anak guru.

Dokumen prestasi:

- Sertifikat prestasi.
- Surat keterangan peringkat.

### Validasi Kelengkapan Dokumen

Status: tersedia

Fungsi:

- Mengecek dokumen wajib.
- Mengecek kombinasi dokumen khusus jalur afirmasi.
- Mengecek kombinasi dokumen khusus jalur mutasi.
- Mengecek sertifikat untuk jalur prestasi.

### Preview Dokumen

Status: tersedia

Fungsi:

- Siswa dapat melihat dokumennya sendiri.
- Admin dapat melihat dokumen pendaftar.

### Pakta Integritas PDF

Status: tersedia

Fungsi:

- Generate PDF pakta integritas dari data pendaftar.

## 6. Portal Siswa

Status: tersedia

Fungsi:

- Menampilkan data pendaftaran.
- Menampilkan status seleksi.
- Menampilkan progress dokumen wajib.
- Akses halaman upload dokumen.
- Akses preview dokumen.
- Akses pakta integritas.

Manfaat:

- Siswa memiliki pusat informasi untuk memantau proses pendaftarannya.

## 7. Registrasi dan Pengelolaan Sekolah

### Registrasi Sekolah Publik

Status: tersedia

Fungsi:

- Input NPSN, nama sekolah, jenjang, status, kabupaten/kota, provinsi, alamat, kontak, website, daya tampung, dan data admin.
- Membuat data sekolah.
- Membuat akun admin sekolah.
- Login otomatis sebagai admin sekolah.

### Manajemen Sekolah oleh Super Admin

Status: tersedia

Fungsi:

- CRUD sekolah.
- Pencarian NPSN, nama, dan kabupaten/kota.
- Filter jenjang, status, sekolah aktif, dan status pendaftaran.
- Melihat jumlah pendaftar per sekolah.

### Pengaturan Sekolah oleh Admin Sekolah

Status: tersedia

Fungsi:

- Edit profil sekolah.
- Edit kontak sekolah.
- Edit koordinat sekolah.
- Edit daya tampung.
- Edit kuota jalur.
- Buka/tutup pendaftaran.
- Set jadwal buka dan tutup pendaftaran.

## 8. Panel Admin dan Backoffice

### Manajemen Pendaftar

Status: tersedia

Fungsi:

- List pendaftar.
- Search nomor pendaftaran, nama, NISN, asal sekolah, dan sekolah tujuan.
- Filter status, jalur, dan sekolah tujuan.
- Edit data pendaftar.
- Ubah status pendaftaran.
- Catatan panitia.

Status pendaftaran:

- Baru.
- Verifikasi.
- Diterima.
- Ditolak.
- Cadangan.

### Scope Admin Sekolah

Status: tersedia

Fungsi:

- Admin sekolah hanya melihat pendaftar milik sekolahnya.
- Dashboard dan chart admin sekolah juga dibatasi berdasarkan sekolahnya.

### Verifikasi Dokumen

Status: tersedia

Fungsi:

- Melihat daftar dokumen pendaftar.
- Preview file dokumen.
- Menerima dokumen.
- Menolak dokumen dengan alasan.
- Filter dokumen berdasarkan status.
- Mencatat log verifikasi dokumen.
- Mengirim email otomatis ke siswa saat dokumen diterima atau ditolak.

Status dokumen:

- Menunggu.
- Diterima.
- Ditolak.

### Riwayat Aktivitas

Status: tersedia

Fungsi:

- Melihat log pendaftaran dibuat.
- Melihat log dokumen diunggah.
- Melihat log dokumen diverifikasi.
- Melihat log perubahan status.
- Menampilkan waktu, aksi, user, status awal, status akhir, dan catatan.

## 9. Dashboard dan Laporan

### Statistik Admin

Status: tersedia

Fungsi:

- Total pendaftar.
- Belum diverifikasi.
- Sedang diverifikasi.
- Diterima.
- Ditolak.
- Polling data berkala.

### Grafik Pendaftar

Status: tersedia

Grafik:

- Pendaftar per jalur.
- Pendaftar per sekolah tujuan.

### Pendaftar Terbaru

Status: tersedia

Fungsi:

- Menampilkan lima pendaftar terbaru.
- Link cepat ke detail/edit pendaftar.

### Kuota Per Jalur

Status: tersedia

Fungsi:

- Menampilkan kuota, terisi, diterima, sisa, dan status penuh per jalur.
- Khusus admin sekolah.

### Export Excel

Status: tersedia

Fungsi:

- Export data pendaftar ke XLSX.
- Mengikuti filter tabel yang sedang aktif.
- Kolom mencakup identitas, kontak, sekolah, jalur, status, catatan, dan tanggal daftar.

## 10. Email dan Notifikasi

### Email Pendaftaran Baru

Status: tersedia

Fungsi:

- Mengirim email saat pendaftaran dibuat.

### Email Status Berubah

Status: tersedia

Fungsi:

- Mengirim email saat status pendaftaran berubah.

### Email Dokumen Diverifikasi

Status: tersedia

Fungsi:

- Mengirim email saat dokumen diterima.
- Mengirim email saat dokumen ditolak.
- Menyertakan catatan panitia jika dokumen ditolak.
- Mengarahkan siswa kembali ke halaman dokumen untuk melihat status atau upload ulang.

## 11. API dan Referensi Data

### Lookup Sekolah by NPSN

Status: tersedia di environment server

Fungsi:

- Mencari sekolah berdasarkan NPSN.
- Cek data lokal terlebih dahulu.
- Fallback ke layanan referensi sekolah eksternal.

### Lookup Siswa by NISN Lokal

Status: tersedia di environment server

Fungsi:

- Mencari data siswa berdasarkan NISN dari data pendaftar lokal.
- Tidak melakukan scraping ke layanan NISN resmi.

Catatan:

- Validasi NISN nasional resmi memerlukan akses Pusdatin/Backbone atau data awal dari sekolah/dinas.
- Scraping layanan NISN resmi tidak disarankan karena ada captcha dan data pribadi siswa.

## 12. Kelebihan Sistem Saat Ini

- Alur pendaftaran digital sudah end-to-end.
- Role siswa, admin sekolah, dan super admin sudah dipisah.
- Dokumen per jalur sudah terstruktur.
- Dashboard admin sudah informatif.
- Pengumuman publik sudah tersedia.
- Export data pendaftar sudah tersedia.
- Rekomendasi jalur sudah ada.
- Kuota per jalur sudah dihitung.
- Email otomatis dokumen diverifikasi sudah aktif.
- Audit log dokumen sudah aktif.

## 13. Pengembangan Lanjutan yang Disarankan

Prioritas tinggi:

1. Ranking otomatis final per jalur.
2. Import CSV/Excel data awal siswa dari sekolah/dinas.
3. Cetak kartu pendaftaran dengan QR Code.
4. Manajemen periode, tahun ajaran, dan gelombang pendaftaran.
5. Bulk approve/reject pendaftar.

Prioritas menengah:

1. Notifikasi WhatsApp.
2. Scan QR untuk verifikasi offline.
3. Pembobotan prestasi lebih detail.
4. Simulasi peluang diterima.
5. Webhook integrasi ke sistem dinas/sekolah.

Prioritas keamanan dan tata kelola:

1. Import data siswa lokal untuk validasi NISN/NIK.
2. Backup dan restore data pendaftaran.
3. Hardening permission file dokumen.
4. Dokumentasi SOP panitia.
