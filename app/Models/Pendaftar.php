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
                // Prefix: 4-char sekolah + 4-digit NPSN suffix to keep uniqueness across sekolah dengan nama mirip
                $prefix = 'SPMB';
                if ($sekolah) {
                    $abbr = strtoupper(substr(preg_replace('/[^A-Z]/i', '', $sekolah->nama), 0, 4)) ?: 'SPMB';
                    $npsnTail = substr($sekolah->npsn ?? '', -4) ?: str_pad((string) $sekolah->id, 4, '0', STR_PAD_LEFT);
                    $prefix = "{$abbr}{$npsnTail}";
                }
                $count = static::whereYear('created_at', $year)
                    ->when($pendaftar->sekolah_id, fn ($q) => $q->where('sekolah_id', $pendaftar->sekolah_id))
                    ->count() + 1;
                $pendaftar->nomor_pendaftaran = sprintf('%s-%s-%05d', $prefix, $year, $count);
            }
        });

        static::created(function (Pendaftar $pendaftar) {
            try {
                \App\Models\PendaftarLog::create([
                    'pendaftar_id' => $pendaftar->id,
                    'user_id' => auth()->id() ?: $pendaftar->user_id,
                    'action' => 'pendaftaran_dibuat',
                    'to' => $pendaftar->status,
                    'catatan' => 'Pendaftaran baru dibuat',
                ]);

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
                    \App\Models\PendaftarLog::create([
                        'pendaftar_id' => $pendaftar->id,
                        'user_id' => auth()->id(),
                        'action' => 'status_diubah',
                        'subject_type' => self::class,
                        'subject_id' => $pendaftar->id,
                        'from' => $pendaftar->statusLama,
                        'to' => $pendaftar->status,
                        'catatan' => $pendaftar->catatan,
                    ]);

                    \Illuminate\Support\Facades\Mail::to($pendaftar->email)
                        ->send(new \App\Mail\StatusBerubah($pendaftar, $pendaftar->statusLama));
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        });
    }

    public ?string $statusLama = null;

    public function logs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PendaftarLog::class)->latest();
    }
}
