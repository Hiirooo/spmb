<?php

namespace App\Mail;

use App\Models\PendaftarDokumen;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DokumenDiverifikasi extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PendaftarDokumen $dokumen) {}

    public function envelope(): Envelope
    {
        $verb = $this->dokumen->status === 'diterima' ? 'Diterima' : 'Ditolak';
        return new Envelope(subject: "Dokumen {$this->dokumen->label} {$verb} - {$this->dokumen->pendaftar->nomor_pendaftaran}");
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.dokumen-diverifikasi',
            with: ['dokumen' => $this->dokumen, 'pendaftar' => $this->dokumen->pendaftar],
        );
    }
}
