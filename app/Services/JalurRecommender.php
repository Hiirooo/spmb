<?php

namespace App\Services;

class JalurRecommender
{
    public const QUESTIONS = [
        'penerima_bansos' => [
            'label' => 'Apakah keluarga Anda menerima bantuan sosial pemerintah (KIP/KKS/PKH)?',
            'options' => [
                'ya' => 'Ya, salah satu/lebih kartu masih aktif',
                'tidak' => 'Tidak menerima',
            ],
        ],
        'penghasilan_ortu' => [
            'label' => 'Berapa penghasilan bulanan orang tua/wali?',
            'options' => [
                '< 1 juta' => 'Kurang dari Rp 1.000.000',
                '1-3 juta' => 'Rp 1.000.000 – Rp 3.000.000',
                '3-5 juta' => 'Rp 3.000.000 – Rp 5.000.000',
                '5-10 juta' => 'Rp 5.000.000 – Rp 10.000.000',
                '> 10 juta' => 'Lebih dari Rp 10.000.000',
            ],
        ],
        'disabilitas' => [
            'label' => 'Apakah Anda penyandang disabilitas?',
            'options' => [
                'ya' => 'Ya, dengan surat keterangan dokter',
                'tidak' => 'Tidak',
            ],
        ],
        'lama_domisili' => [
            'label' => 'Sudah berapa lama Anda berdomisili di alamat sesuai KK?',
            'options' => [
                '< 6 bulan' => 'Kurang dari 6 bulan',
                '6-24 bulan' => '6 bulan – 2 tahun',
                '> 2 tahun' => 'Lebih dari 2 tahun',
            ],
        ],
        'jarak_sekolah' => [
            'label' => 'Berapa jarak rumah Anda ke sekolah tujuan?',
            'options' => [
                '< 3 km' => 'Kurang dari 3 km (zona dekat)',
                '3-10 km' => '3 – 10 km (zona menengah)',
                '> 10 km' => 'Lebih dari 10 km',
            ],
        ],
        'mutasi_ortu' => [
            'label' => 'Apakah Anda pindah karena mutasi tugas orang tua/wali (TNI/Polri/ASN/swasta)?',
            'options' => [
                'ya' => 'Ya, dengan SK mutasi',
                'tidak' => 'Tidak',
            ],
        ],
        'anak_guru' => [
            'label' => 'Apakah Anda anak guru di sekolah tujuan?',
            'options' => [
                'ya' => 'Ya',
                'tidak' => 'Tidak',
            ],
        ],
        'rerata_rapor' => [
            'label' => 'Berapa rata-rata nilai rapor SMP Anda (semester 1–5)?',
            'options' => [
                '< 75' => 'Kurang dari 75',
                '75-84' => '75 – 84',
                '85-89' => '85 – 89',
                '>= 90' => '90 atau lebih',
            ],
        ],
        'punya_prestasi' => [
            'label' => 'Apakah Anda memiliki prestasi akademik atau non-akademik bersertifikat?',
            'options' => [
                'tidak' => 'Tidak ada',
                'kabupaten_kota' => 'Tingkat Kabupaten/Kota',
                'provinsi' => 'Tingkat Provinsi',
                'nasional' => 'Tingkat Nasional',
                'internasional' => 'Tingkat Internasional',
            ],
        ],
        'sudah_tka' => [
            'label' => 'Apakah Anda sudah mengikuti Tes Kemampuan Akademik (TKA)?',
            'options' => [
                'ya' => 'Ya, sudah ada hasil',
                'tidak' => 'Belum',
            ],
        ],
    ];

    /**
     * @param  array<string, string>  $answers
     * @return array<string, array{score: int, percent: int, reasons: array<int, string>, eligible: bool}>
     */
    public static function score(array $answers): array
    {
        $jalur = [
            'afirmasi' => ['score' => 0, 'reasons' => [], 'eligible' => false],
            'domisili' => ['score' => 0, 'reasons' => [], 'eligible' => false],
            'mutasi' => ['score' => 0, 'reasons' => [], 'eligible' => false],
            'prestasi' => ['score' => 0, 'reasons' => [], 'eligible' => false],
        ];

        $bansos = $answers['penerima_bansos'] ?? null;
        $penghasilan = $answers['penghasilan_ortu'] ?? null;
        $disabilitas = $answers['disabilitas'] ?? null;
        if ($bansos === 'ya') {
            $jalur['afirmasi']['score'] += 50;
            $jalur['afirmasi']['eligible'] = true;
            $jalur['afirmasi']['reasons'][] = 'Menerima bantuan KIP/KKS/PKH (syarat utama afirmasi).';
        }
        if (in_array($penghasilan, ['< 1 juta', '1-3 juta'], true)) {
            $jalur['afirmasi']['score'] += 25;
            $jalur['afirmasi']['eligible'] = true;
            $jalur['afirmasi']['reasons'][] = 'Penghasilan orang tua tergolong rendah.';
        } elseif ($penghasilan === '3-5 juta') {
            $jalur['afirmasi']['score'] += 10;
        }
        if ($disabilitas === 'ya') {
            $jalur['afirmasi']['score'] += 35;
            $jalur['afirmasi']['eligible'] = true;
            $jalur['afirmasi']['reasons'][] = 'Penyandang disabilitas (kuota khusus afirmasi).';
        }

        $lamaDomisili = $answers['lama_domisili'] ?? null;
        $jarak = $answers['jarak_sekolah'] ?? null;
        $rapor = $answers['rerata_rapor'] ?? null;
        if ($lamaDomisili === '> 2 tahun') {
            $jalur['domisili']['score'] += 25;
            $jalur['domisili']['eligible'] = true;
            $jalur['domisili']['reasons'][] = 'Berdomisili di alamat KK lebih dari 2 tahun.';
        } elseif ($lamaDomisili === '6-24 bulan') {
            $jalur['domisili']['score'] += 10;
        }
        if ($jarak === '< 3 km') {
            $jalur['domisili']['score'] += 30;
            $jalur['domisili']['eligible'] = true;
            $jalur['domisili']['reasons'][] = 'Rumah berada di zona dekat (<3 km, prioritas Zona I).';
        } elseif ($jarak === '3-10 km') {
            $jalur['domisili']['score'] += 18;
            $jalur['domisili']['eligible'] = true;
            $jalur['domisili']['reasons'][] = 'Rumah berada di zona menengah (3–10 km, Zona II).';
        }
        if ($rapor === '>= 90') {
            $jalur['domisili']['score'] += 20;
            $jalur['domisili']['reasons'][] = 'Nilai rapor sangat baik mendukung jalur domisili.';
        } elseif ($rapor === '85-89') {
            $jalur['domisili']['score'] += 12;
        }

        $mutasi = $answers['mutasi_ortu'] ?? null;
        $anakGuru = $answers['anak_guru'] ?? null;
        if ($mutasi === 'ya') {
            $jalur['mutasi']['score'] += 60;
            $jalur['mutasi']['eligible'] = true;
            $jalur['mutasi']['reasons'][] = 'Memiliki SK mutasi tugas orang tua/wali.';
        }
        if ($anakGuru === 'ya') {
            $jalur['mutasi']['score'] += 50;
            $jalur['mutasi']['eligible'] = true;
            $jalur['mutasi']['reasons'][] = 'Anak guru di sekolah tujuan (kuota anak guru).';
        }

        $prestasi = $answers['punya_prestasi'] ?? null;
        $tka = $answers['sudah_tka'] ?? null;
        $prestasiScore = match ($prestasi) {
            'internasional' => 50,
            'nasional' => 35,
            'provinsi' => 22,
            'kabupaten_kota' => 12,
            default => 0,
        };
        if ($prestasiScore > 0) {
            $jalur['prestasi']['score'] += $prestasiScore;
            $jalur['prestasi']['eligible'] = true;
            $jalur['prestasi']['reasons'][] = sprintf(
                'Memiliki prestasi tingkat %s.',
                ucfirst(str_replace('_', '/', $prestasi))
            );
        }
        if ($rapor === '>= 90') {
            $jalur['prestasi']['score'] += 25;
            $jalur['prestasi']['eligible'] = true;
            $jalur['prestasi']['reasons'][] = 'Nilai rapor 90+ memenuhi syarat prestasi akademik.';
        } elseif ($rapor === '85-89') {
            $jalur['prestasi']['score'] += 15;
            $jalur['prestasi']['eligible'] = true;
            $jalur['prestasi']['reasons'][] = 'Nilai rapor 85+ kompetitif untuk jalur prestasi.';
        }
        if ($tka === 'ya') {
            $jalur['prestasi']['score'] += 15;
            $jalur['prestasi']['reasons'][] = 'Sudah memiliki hasil TKA (syarat baru jalur prestasi 2026).';
        } elseif ($prestasiScore > 0 || in_array($rapor, ['85-89', '>= 90'], true)) {
            $jalur['prestasi']['reasons'][] = 'Catatan: jalur prestasi akademik wajib menyertakan hasil TKA.';
        }

        $maxPossible = [
            'afirmasi' => 110,
            'domisili' => 75,
            'mutasi' => 110,
            'prestasi' => 90,
        ];

        foreach ($jalur as $key => &$data) {
            $cap = $maxPossible[$key] ?? 100;
            $percent = (int) round(min($data['score'], $cap) / $cap * 100);
            $data['percent'] = $percent;
            if (! $data['eligible']) {
                $data['reasons'][] = 'Tidak ada syarat utama jalur ini yang terpenuhi.';
            }
        }
        unset($data);

        uasort($jalur, fn ($a, $b) => $b['score'] <=> $a['score']);

        return $jalur;
    }
}
