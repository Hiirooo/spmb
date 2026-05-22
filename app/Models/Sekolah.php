<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Sekolah extends Model
{
    protected $fillable = [
        'npsn',
        'nama',
        'slug',
        'jenjang',
        'status_negeri',
        'kabupaten_kota',
        'provinsi',
        'alamat',
        'email_kontak',
        'telepon_kontak',
        'website',
        'logo_path',
        'deskripsi',
        'daya_tampung_total',
        'kuota_jalur',
        'zona_radius',
        'is_active',
        'is_pendaftaran_buka',
        'pendaftaran_dibuka_pada',
        'pendaftaran_ditutup_pada',
    ];

    protected function casts(): array
    {
        return [
            'kuota_jalur' => 'array',
            'zona_radius' => 'array',
            'is_active' => 'boolean',
            'is_pendaftaran_buka' => 'boolean',
            'pendaftaran_dibuka_pada' => 'datetime',
            'pendaftaran_ditutup_pada' => 'datetime',
            'daya_tampung_total' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Sekolah $sekolah) {
            if (empty($sekolah->slug)) {
                $sekolah->slug = static::uniqueSlug($sekolah->nama);
            }
        });
    }

    public static function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }
        return $slug;
    }

    public function admins(): HasMany
    {
        return $this->hasMany(User::class)->where('role', 'sekolah_admin');
    }

    public function pendaftars(): HasMany
    {
        return $this->hasMany(Pendaftar::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getKuotaForJalur(string $jalur): int
    {
        $kuota = $this->kuota_jalur ?? static::defaultKuota();
        return $kuota[$jalur] ?? 0;
    }

    public function getKuotaTerisi(string $jalur): int
    {
        return $this->pendaftars()
            ->where('jalur_pendaftaran', $jalur)
            ->whereIn('status', ['baru', 'verifikasi', 'diterima', 'cadangan'])
            ->count();
    }

    public static function defaultKuota(): array
    {
        return [
            'afirmasi' => 30,
            'domisili' => 30,
            'mutasi' => 5,
            'prestasi' => 35,
        ];
    }
}
