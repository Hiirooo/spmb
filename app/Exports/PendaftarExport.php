<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PendaftarExport
{
    public function __construct(public Builder $query, public ?string $filename = null) {}

    public function download(): StreamedResponse
    {
        $filename = $this->filename ?: 'pendaftar-'.now()->format('YmdHi').'.xlsx';

        return response()->streamDownload(function (): void {
            $writer = new Writer();
            $writer->openToFile('php://output');

            $headerStyle = (new Style())
                ->setFontBold()
                ->setBackgroundColor(Color::DARK_BLUE)
                ->setFontColor(Color::WHITE);

            $headers = [
                'No. Pendaftaran', 'Nama Lengkap', 'NISN', 'NIK', 'Email', 'No. Telepon',
                'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat',
                'Nama Ayah', 'Nama Ibu', 'Pekerjaan Ortu', 'Penghasilan Ortu',
                'Asal Sekolah', 'Tahun Lulus', 'Sekolah Tujuan',
                'Jalur', 'Kategori Prestasi', 'Tingkat Prestasi',
                'Status', 'Catatan', 'Tanggal Daftar',
            ];
            $writer->addRow(Row::fromValues($headers, $headerStyle));

            $this->query->chunk(500, function ($pendaftars) use ($writer) {
                foreach ($pendaftars as $p) {
                    $writer->addRow(Row::fromValues([
                        $p->nomor_pendaftaran,
                        $p->nama_lengkap,
                        $p->nisn,
                        $p->nik,
                        $p->email,
                        $p->no_telepon,
                        $p->jenis_kelamin === 'L' ? 'Laki-laki' : ($p->jenis_kelamin === 'P' ? 'Perempuan' : ''),
                        $p->tempat_lahir,
                        $p->tanggal_lahir?->format('d-m-Y'),
                        $p->alamat,
                        $p->nama_ayah,
                        $p->nama_ibu,
                        $p->pekerjaan_ortu,
                        $p->penghasilan_ortu,
                        $p->asal_sekolah,
                        $p->tahun_lulus,
                        $p->sekolah_tujuan,
                        ucfirst($p->jalur_pendaftaran ?? ''),
                        $p->kategori_prestasi ? ucfirst(str_replace('_', ' ', $p->kategori_prestasi)) : '',
                        $p->tingkat_prestasi ? ucfirst(str_replace('_', '/', $p->tingkat_prestasi)) : '',
                        ucfirst($p->status ?? ''),
                        $p->catatan,
                        $p->created_at?->format('d-m-Y H:i'),
                    ]));
                }
            });

            $writer->close();
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
