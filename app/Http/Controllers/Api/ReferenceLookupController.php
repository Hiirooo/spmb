<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Sekolah;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReferenceLookupController extends Controller
{
    public function siswaByNisnQuery(Request $request): JsonResponse
    {
        $nisn = (string) ($_GET['nisn'] ?? '');

        if (! preg_match('/^[0-9]+$/', $nisn) || strlen($nisn) !== 10) {
            return response()->json([
                'success' => false,
                'message' => 'NISN harus 10 digit angka.',
            ], 422);
        }

        return $this->siswaByNisn($nisn);
    }

    public function siswaByNisn(string $nisn): JsonResponse
    {
        if (! preg_match('/^[0-9]{10}$/', $nisn)) {
            return response()->json([
                'success' => false,
                'message' => 'NISN harus 10 digit angka.',
            ], 422);
        }

        $pendaftar = Pendaftar::query()
            ->with('sekolah:id,npsn,nama,jenjang,kabupaten_kota,provinsi')
            ->where('nisn', $nisn)
            ->latest('id')
            ->first();

        if (! $pendaftar) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan di aplikasi ini. Data NISN resmi Kemendikdasmen memerlukan captcha/akses resmi, sehingga tidak diproxy otomatis.',
                'source' => 'local',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'source' => 'local',
            'data' => [
                'nisn' => $pendaftar->nisn,
                'nama_lengkap' => $pendaftar->nama_lengkap,
                'jenis_kelamin' => $pendaftar->jenis_kelamin,
                'tempat_lahir' => $pendaftar->tempat_lahir,
                'tanggal_lahir' => $pendaftar->tanggal_lahir?->format('Y-m-d'),
                'asal_sekolah' => $pendaftar->asal_sekolah,
                'tahun_lulus' => $pendaftar->tahun_lulus,
                'status_pendaftaran' => $pendaftar->status,
                'sekolah_tujuan' => $pendaftar->sekolah ? [
                    'npsn' => $pendaftar->sekolah->npsn,
                    'nama' => $pendaftar->sekolah->nama,
                    'jenjang' => $pendaftar->sekolah->jenjang,
                    'kabupaten_kota' => $pendaftar->sekolah->kabupaten_kota,
                    'provinsi' => $pendaftar->sekolah->provinsi,
                ] : null,
            ],
        ]);
    }

    public function sekolahByNpsnQuery(Request $request): JsonResponse
    {
        return $this->sekolahByNpsn((string) ($_GET['npsn'] ?? ''));
    }

    public function sekolahByNpsn(string $npsn): JsonResponse
    {
        if (! preg_match('/^[0-9]{8}$/', $npsn)) {
            return response()->json([
                'success' => false,
                'message' => 'NPSN harus 8 digit angka.',
            ], 422);
        }

        $sekolah = Sekolah::query()->where('npsn', $npsn)->first();

        if ($sekolah) {
            return response()->json([
                'success' => true,
                'source' => 'local',
                'data' => $this->formatLocalSekolah($sekolah),
            ]);
        }

        $response = Http::acceptJson()
            ->timeout(10)
            ->get('https://sekolah.devapi.id/sekolah', [
                'npsn' => $npsn,
                'limit' => 1,
            ]);

        if (! $response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Data sekolah tidak ditemukan.',
                'source' => 'external',
            ], 404);
        }

        $school = $response->json('data.0');

        if (! $school) {
            return response()->json([
                'success' => false,
                'message' => 'Data sekolah tidak ditemukan.',
                'source' => 'external',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'source' => 'sekolah.devapi.id',
            'data' => $this->formatExternalSekolah($school),
        ]);
    }

    private function formatLocalSekolah(Sekolah $sekolah): array
    {
        return [
            'npsn' => $sekolah->npsn,
            'nama' => $sekolah->nama,
            'jenjang' => $sekolah->jenjang,
            'status' => $sekolah->status_negeri,
            'alamat' => $sekolah->alamat,
            'kabupaten_kota' => $sekolah->kabupaten_kota,
            'provinsi' => $sekolah->provinsi,
            'email' => $sekolah->email_kontak,
            'telepon' => $sekolah->telepon_kontak,
            'website' => $sekolah->website,
            'latitude' => $sekolah->latitude,
            'longitude' => $sekolah->longitude,
        ];
    }

    private function formatExternalSekolah(array $school): array
    {
        return [
            'npsn' => $school['npsn'] ?? null,
            'nama' => $school['nama'] ?? null,
            'jenjang' => $school['bentukPendidikan'] ?? null,
            'status' => $school['statusSatuanPendidikan'] ?? null,
            'akreditasi' => $school['akreditasi'] ?? null,
            'alamat' => $school['alamat']['jalan'] ?? null,
            'desa_kelurahan' => $school['alamat']['nama_desa'] ?? null,
            'kecamatan' => $school['alamat']['nama_kecamatan'] ?? null,
            'kabupaten_kota' => $school['alamat']['nama_kabupaten'] ?? null,
            'provinsi' => $school['alamat']['nama_provinsi'] ?? null,
            'email' => $school['kontak']['email'] ?? null,
            'telepon' => $school['kontak']['nomor_telepon'] ?? null,
            'website' => $school['kontak']['website'] ?? null,
            'latitude' => $school['lokasi']['lintang'] ?? null,
            'longitude' => $school['lokasi']['bujur'] ?? null,
        ];
    }
}
