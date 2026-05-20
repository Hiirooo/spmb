# SPMB

Sistem Penerimaan Mahasiswa Baru — Laravel 13 application deployed at https://spmb.rasyidabdulah.codes

## Stack

- Laravel 13.11.2
- PHP 8.5.2
- SQLite (default)

## Local development

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## Deployment

- Host: aaPanel (`/www/wwwroot/spmb.rasyidabdulah.codes`)
- Web root: `public/`
- Owner: `www:www`

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
