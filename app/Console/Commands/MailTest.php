<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailTest extends Command
{
    protected $signature = 'mail:test {to : Recipient email}';

    protected $description = 'Send a test email using current MAIL_MAILER config';

    public function handle(): int
    {
        $to = $this->argument('to');

        $this->info('Sending test mail to '.$to.' via '.config('mail.default').'...');

        try {
            Mail::raw(
                "Halo,\n\nIni adalah email tes dari SPMB Sumsel platform.\n".
                "Server: ".config('app.url')."\n".
                "Driver: ".config('mail.default')."\n".
                "Waktu: ".now()->toDateTimeString()."\n\n".
                "Jika Anda menerima email ini, konfigurasi mail sudah benar.",
                function ($message) use ($to) {
                    $message->to($to)->subject('Test Mail - SPMB Sumsel ['.now()->format('His').']');
                }
            );
        } catch (\Throwable $e) {
            $this->error('Gagal: '.$e->getMessage());
            return self::FAILURE;
        }

        $this->info('Berhasil. Cek inbox / log / mailtrap sesuai driver.');
        if (config('mail.default') === 'log') {
            $this->line('  Log: storage/logs/laravel.log');
        }

        return self::SUCCESS;
    }
}
