<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendaftarDokumen extends Model
{
    protected $fillable = [
        'pendaftar_id',
        'jenis',
        'label',
        'path',
        'original_name',
        'mime_type',
        'size_bytes',
        'status',
        'catatan_verifikasi',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'size_bytes' => 'integer',
        ];
    }

    public function pendaftar(): BelongsTo
    {
        return $this->belongsTo(Pendaftar::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getSizeFormattedAttribute(): string
    {
        $kb = $this->size_bytes / 1024;
        return $kb < 1024
            ? number_format($kb, 1).' KB'
            : number_format($kb / 1024, 2).' MB';
    }

    protected static function booted(): void
    {
        static::created(function (PendaftarDokumen $dokumen) {
            try {
                \App\Models\PendaftarLog::create([
                    'pendaftar_id' => $dokumen->pendaftar_id,
                    'user_id' => auth()->id(),
                    'action' => 'dokumen_diunggah',
                    'subject_type' => self::class,
                    'subject_id' => $dokumen->id,
                    'to' => 'menunggu',
                    'catatan' => $dokumen->label.' diunggah',
                ]);
            } catch (\Throwable $e) {
                report($e);
            }
        });

        static::updated(function (PendaftarDokumen $dokumen) {
            if ($dokumen->wasChanged('status') && in_array($dokumen->status, ['diterima', 'ditolak'], true)) {
                try {
                    \App\Models\PendaftarLog::create([
                        'pendaftar_id' => $dokumen->pendaftar_id,
                        'user_id' => $dokumen->verified_by ?? auth()->id(),
                        'action' => 'dokumen_diverifikasi',
                        'subject_type' => self::class,
                        'subject_id' => $dokumen->id,
                        'from' => $dokumen->getOriginal('status'),
                        'to' => $dokumen->status,
                        'catatan' => $dokumen->label.': '.($dokumen->catatan_verifikasi ?: ''),
                    ]);

                    \Illuminate\Support\Facades\Mail::to($dokumen->pendaftar->email)
                        ->send(new \App\Mail\DokumenDiverifikasi($dokumen));
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        });
    }
}
