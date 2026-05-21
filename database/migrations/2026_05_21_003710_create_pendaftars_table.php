<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pendaftaran', 20)->unique();
            $table->string('nama_lengkap');
            $table->string('nik', 16)->unique();
            $table->string('email')->unique();
            $table->string('no_telepon', 20);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('asal_sekolah');
            $table->year('tahun_lulus');
            $table->string('program_studi');
            $table->enum('jalur_pendaftaran', ['reguler', 'prestasi', 'beasiswa', 'transfer']);
            $table->enum('status', ['baru', 'verifikasi', 'diterima', 'ditolak', 'cadangan'])->default('baru');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('program_studi');
            $table->index('jalur_pendaftaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
