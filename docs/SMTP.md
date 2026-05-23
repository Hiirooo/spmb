# SPMB Sumsel — Konfigurasi SMTP

Email saat ini menggunakan driver `log` (tertulis ke `storage/logs/laravel.log`).
Untuk produksi, ganti ke salah satu provider berikut.

## Cek Driver Aktif

```bash
sudo -u www -H /www/server/php/85/bin/php artisan mail:test recipient@example.com
```

## Provider yang Direkomendasikan

### 1) Resend (paling simpel, free tier 3.000/bulan)

```env
MAIL_MAILER=resend
RESEND_API_KEY=re_xxxxxxxxxxxx
MAIL_FROM_ADDRESS=noreply@spmb.rasyidabdulah.codes
MAIL_FROM_NAME="SPMB Sumsel"
```

Setup:
1. Daftar di https://resend.com → Verifikasi domain `rasyidabdulah.codes`
2. Tambah DNS record (SPF, DKIM) di zone file:
   - TXT v=spf1 include:resend.com ~all
   - 3 record DKIM dari Resend dashboard
3. Generate API key → masukkan ke `.env`
4. `composer require resend/resend-laravel` (sudah include di Laravel 13)

### 2) Mailgun (free tier 5.000/bulan, 3 bulan)

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.spmb.rasyidabdulah.codes
MAILGUN_SECRET=key-xxxxxxxxxxxx
MAILGUN_ENDPOINT=api.mailgun.net
MAIL_FROM_ADDRESS=noreply@spmb.rasyidabdulah.codes
MAIL_FROM_NAME="SPMB Sumsel"
```

`composer require symfony/mailgun-mailer symfony/http-client`

### 3) Generic SMTP (e.g., Gmail/Zoho/SES via SMTP)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=youraccount@gmail.com
MAIL_PASSWORD="app-password-bukan-password-akun"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=youraccount@gmail.com
MAIL_FROM_NAME="SPMB Sumsel"
```

Catatan Gmail: butuh App Password (Settings → Security → 2FA → App passwords).

## Setelah Update .env

```bash
cd /www/wwwroot/spmb.rasyidabdulah.codes
sudo -u www -H /www/server/php/85/bin/php artisan config:clear
sudo -u www -H /www/server/php/85/bin/php artisan config:cache
sudo -u www -H /www/server/php/85/bin/php artisan mail:test you@yourmail.com
```

## Queue (Direkomendasikan untuk Produksi)

Email saat ini dikirim sinkron. Untuk volume tinggi, gunakan queue:

```env
QUEUE_CONNECTION=database
```

Lalu:

```bash
sudo -u www -H /www/server/php/85/bin/php artisan queue:work --tries=3
```

Atau pakai supervisor untuk daemonize.
