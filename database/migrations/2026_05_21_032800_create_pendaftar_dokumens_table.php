<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftar_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained()->cascadeOnDelete();
            $table->string('jenis');
            $table->string('label');
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type', 100);
            $table->unsignedInteger('size_bytes');
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu')->index();
            $table->text('catatan_verifikasi')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->unique(['pendaftar_id', 'jenis']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftar_dokumens');
    }
};
