<?php

namespace App\Mail;

use App\Models\Pendaftar;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendaftarBaru extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pendaftar $pendaftar) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Pendaftaran Anda Tercatat - '.$this->pendaftar->nomor_pendaftaran);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pendaftar-baru',
            with: ['pendaftar' => $this->pendaftar],
        );
    }
}
