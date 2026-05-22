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
}
