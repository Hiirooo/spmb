<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendaftar extends Model
{
    protected $fillable = [
        'user_id',
        'sekolah_id',
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

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
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
                $sekolah = $pendaftar->sekolah_id
                    ? \App\Models\Sekolah::find($pendaftar->sekolah_id)
                    : null;
                $prefix = $sekolah
                    ? strtoupper(substr(preg_replace('/[^A-Z]/i', '', $sekolah->nama), 0, 4))
                    : 'SPMB';
                $count = static::whereYear('created_at', $year)
                    ->when($pendaftar->sekolah_id, fn ($q) => $q->where('sekolah_id', $pendaftar->sekolah_id))
                    ->count() + 1;
                $pendaftar->nomor_pendaftaran = sprintf('%s-%s-%05d', $prefix ?: 'SPMB', $year, $count);
            }
        });

        static::created(function (Pendaftar $pendaftar) {
            try {
                \Illuminate\Support\Facades\Mail::to($pendaftar->email)
                    ->send(new \App\Mail\PendaftarBaru($pendaftar));
            } catch (\Throwable $e) {
                report($e);
            }
        });

        static::updating(function (Pendaftar $pendaftar) {
            if ($pendaftar->isDirty('status')) {
                $pendaftar->statusLama = $pendaftar->getOriginal('status');
            }
        });

        static::updated(function (Pendaftar $pendaftar) {
            if (! empty($pendaftar->statusLama) && $pendaftar->statusLama !== $pendaftar->status) {
                try {
                    \Illuminate\Support\Facades\Mail::to($pendaftar->email)
                        ->send(new \App\Mail\StatusBerubah($pendaftar, $pendaftar->statusLama));
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        });
    }

    public ?string $statusLama = null;
}
