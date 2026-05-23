<?php

namespace App\Mail;

use App\Models\Pendaftar;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusBerubah extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pendaftar $pendaftar, public string $statusLama) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Update Status Pendaftaran - '.$this->pendaftar->nomor_pendaftaran);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.status-berubah',
            with: ['pendaftar' => $this->pendaftar, 'statusLama' => $this->statusLama],
        );
    }
}
