<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->string('nisn', 10)->nullable()->after('nik')->index();
            $table->string('nama_ayah')->nullable()->after('alamat');
            $table->string('nama_ibu')->nullable()->after('nama_ayah');
            $table->string('pekerjaan_ortu')->nullable()->after('nama_ibu');
            $table->string('penghasilan_ortu')->nullable()->after('pekerjaan_ortu');

            $table->renameColumn('program_studi', 'sekolah_tujuan');

            $table->string('kategori_prestasi')->nullable()->after('jalur_pendaftaran');
            $table->string('tingkat_prestasi')->nullable()->after('kategori_prestasi');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropColumn([
                'nisn', 'nama_ayah', 'nama_ibu', 'pekerjaan_ortu',
                'penghasilan_ortu', 'kategori_prestasi', 'tingkat_prestasi',
            ]);
            $table->renameColumn('sekolah_tujuan', 'program_studi');
        });
    }
};
