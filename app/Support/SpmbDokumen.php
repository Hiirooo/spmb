<?php

namespace App\Support;

class SpmbDokumen
{
    public const MAX_SIZE_MB = 2;

    public const ACCEPTED_MIMES = ['application/pdf', 'image/jpeg', 'image/png'];

    public const ACCEPTED_EXTENSIONS = 'pdf,jpg,jpeg,png';

    public const JALUR = [
        'afirmasi' => 'Afirmasi',
        'domisili' => 'Domisili',
        'mutasi' => 'Mutasi',
        'prestasi' => 'Prestasi',
    ];

    public const KATEGORI_PRESTASI = [
        'akademik' => 'Akademik (rapor)',
        'non_akademik' => 'Non-akademik (olahraga/seni/keagamaan/kepramukaan)',
        'tka' => 'Nilai Tes Kemampuan Akademik (TKA)',
    ];

    public const TINGKAT_PRESTASI = [
        'internasional' => 'Internasional',
        'nasional' => 'Nasional',
        'provinsi' => 'Provinsi',
        'kabupaten_kota' => 'Kabupaten/Kota',
    ];

    public const DOKUMEN = [
        'kk' => [
            'label' => 'Kartu Keluarga',
            'desc' => 'KK terbaru, sesuai data Dukcapil',
            'jalur' => ['afirmasi', 'domisili', 'mutasi', 'prestasi'],
        ],
        'akta_kelahiran' => [
            'label' => 'Akta Kelahiran',
            'desc' => 'Akta kelahiran asli yang dapat dibaca jelas',
            'jalur' => ['afirmasi', 'domisili', 'mutasi', 'prestasi'],
        ],
        'ijazah_skl' => [
            'label' => 'Ijazah / Surat Keterangan Lulus',
            'desc' => 'Ijazah SMP/sederajat atau SKL dari sekolah asal',
            'jalur' => ['afirmasi', 'domisili', 'mutasi', 'prestasi'],
        ],
        'rapor' => [
            'label' => 'Rapor 5 Semester',
            'desc' => 'Rapor SMP semester 1–5 dijadikan satu file PDF',
            'jalur' => ['afirmasi', 'domisili', 'mutasi', 'prestasi'],
        ],
        'foto' => [
            'label' => 'Pas Foto',
            'desc' => 'Pas foto berwarna terbaru, latar merah',
            'jalur' => ['afirmasi', 'domisili', 'mutasi', 'prestasi'],
        ],
        'pakta_integritas' => [
            'label' => 'Pakta Integritas',
            'desc' => 'Pakta integritas yang sudah ditandatangani di atas materai',
            'jalur' => ['afirmasi', 'domisili', 'mutasi', 'prestasi'],
        ],
        'kip_kks_pkh' => [
            'label' => 'Kartu KIP / KKS / PKH',
            'desc' => 'Salah satu kartu bantuan sosial yang masih berlaku',
            'jalur' => ['afirmasi'],
        ],
        'sktm' => [
            'label' => 'Surat Keterangan Tidak Mampu',
            'desc' => 'SKTM dari kelurahan setempat (jika tidak ada KIP/KKS/PKH)',
            'jalur' => ['afirmasi'],
        ],
        'surat_disabilitas' => [
            'label' => 'Surat Keterangan Disabilitas',
            'desc' => 'Bagi penyandang disabilitas, surat dari dokter/RS yang berwenang',
            'jalur' => ['afirmasi'],
        ],
        'surat_domisili' => [
            'label' => 'Surat Keterangan Domisili',
            'desc' => 'Surat dari kelurahan/desa, minimal 2 tahun di alamat sekarang',
            'jalur' => ['domisili'],
        ],
        'sk_mutasi_ortu' => [
            'label' => 'SK Mutasi Orang Tua',
            'desc' => 'Surat keputusan perpindahan tugas dari instansi orang tua',
            'jalur' => ['mutasi'],
        ],
        'sk_anak_guru' => [
            'label' => 'SK Anak Guru',
            'desc' => 'Surat keterangan anak guru dari sekolah tempat orang tua mengajar',
            'jalur' => ['mutasi'],
        ],
        'sertifikat_prestasi' => [
            'label' => 'Sertifikat Prestasi',
            'desc' => 'Sertifikat juara akademik/non-akademik tertinggi yang dimiliki',
            'jalur' => ['prestasi'],
        ],
        'surat_keterangan_peringkat' => [
            'label' => 'Surat Keterangan Peringkat',
            'desc' => 'Surat keterangan peringkat dari sekolah asal (5 besar paralel)',
            'jalur' => ['prestasi'],
        ],
    ];

    public static function requiredForJalur(string $jalur): array
    {
        return collect(self::DOKUMEN)
            ->filter(fn (array $d) => in_array($jalur, $d['jalur'], true))
            ->map(fn (array $d, string $key) => array_merge($d, ['jenis' => $key]))
            ->values()
            ->all();
    }

    public static function label(string $jenis): string
    {
        return self::DOKUMEN[$jenis]['label'] ?? $jenis;
    }

    public static function isOptional(string $jenis, string $jalur): bool
    {
        return in_array($jenis, ['sktm', 'surat_disabilitas', 'sk_anak_guru', 'surat_keterangan_peringkat'], true);
    }

    /**
     * Validasi cross-field per jalur. Return array of error messages (kosong = OK).
     *
     * @param  array<string, mixed>  $existing  Map jenis => bool (sudah upload)
     * @return array<int, string>
     */
    public static function validateCompleteness(string $jalur, array $existing): array
    {
        $errors = [];

        if ($jalur === 'afirmasi') {
            $hasKipKks = $existing['kip_kks_pkh'] ?? false;
            $hasSktm = $existing['sktm'] ?? false;
            $hasDisabilitas = $existing['surat_disabilitas'] ?? false;
            if (! $hasKipKks && ! $hasSktm && ! $hasDisabilitas) {
                $errors[] = 'Jalur afirmasi memerlukan minimal salah satu: Kartu KIP/KKS/PKH, atau SKTM, atau Surat Keterangan Disabilitas.';
            }
        }

        if ($jalur === 'mutasi') {
            $hasMutasi = $existing['sk_mutasi_ortu'] ?? false;
            $hasAnakGuru = $existing['sk_anak_guru'] ?? false;
            if (! $hasMutasi && ! $hasAnakGuru) {
                $errors[] = 'Jalur mutasi memerlukan minimal salah satu: SK Mutasi Orang Tua atau SK Anak Guru.';
            }
        }

        if ($jalur === 'prestasi') {
            $hasSertifikat = $existing['sertifikat_prestasi'] ?? false;
            if (! $hasSertifikat) {
                $errors[] = 'Jalur prestasi memerlukan Sertifikat Prestasi yang sah.';
            }
        }

        $required = collect(self::requiredForJalur($jalur))
            ->reject(fn ($d) => self::isOptional($d['jenis'], $jalur));

        foreach ($required as $req) {
            if (empty($existing[$req['jenis']])) {
                $errors[] = "Dokumen wajib belum diunggah: {$req['label']}.";
            }
        }

        return $errors;
    }
}
