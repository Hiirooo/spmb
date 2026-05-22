<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendaftar extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_pendaftaran',
        'nama_lengkap',
        'nik',
        'nisn',
        'email',
        'no_telepon',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ortu',
        'penghasilan_ortu',
        'asal_sekolah',
        'tahun_lulus',
        'sekolah_tujuan',
        'jalur_pendaftaran',
        'kategori_prestasi',
        'tingkat_prestasi',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tahun_lulus' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(PendaftarDokumen::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Pendaftar $pendaftar) {
            if (empty($pendaftar->nomor_pendaftaran)) {
                $year = now()->format('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $pendaftar->nomor_pendaftaran = sprintf('SPMB-%s-%05d', $year, $count);
            }
        });
    }
}
