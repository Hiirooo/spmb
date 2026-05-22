<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('npsn', 8)->unique();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->enum('jenjang', ['SMA', 'SMK', 'SMP', 'SD'])->default('SMA');
            $table->enum('status_negeri', ['negeri', 'swasta'])->default('negeri');
            $table->string('kabupaten_kota');
            $table->string('provinsi')->default('Sumatera Selatan');
            $table->text('alamat')->nullable();
            $table->string('email_kontak')->nullable();
            $table->string('telepon_kontak', 25)->nullable();
            $table->string('website')->nullable();
            $table->string('logo_path')->nullable();
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('daya_tampung_total')->default(0);
            $table->json('kuota_jalur')->nullable();
            $table->json('zona_radius')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_pendaftaran_buka')->default(true)->index();
            $table->timestamp('pendaftaran_dibuka_pada')->nullable();
            $table->timestamp('pendaftaran_ditutup_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolahs');
    }
};
