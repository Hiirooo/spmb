<?php

namespace App\Livewire;

use App\Models\PendaftarDokumen;
use App\Support\SpmbDokumen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadDokumen extends Component
{
    use WithFileUploads;

    public array $uploads = [];

    public function rules(): array
    {
        $rules = [];
        $jalur = Auth::user()->pendaftar->jalur_pendaftaran;
        foreach (SpmbDokumen::requiredForJalur($jalur) as $req) {
            $rules["uploads.{$req['jenis']}"] = [
                'nullable',
                'file',
                'mimes:'.SpmbDokumen::ACCEPTED_EXTENSIONS,
                'max:'.(SpmbDokumen::MAX_SIZE_MB * 1024),
            ];
        }
        return $rules;
    }

    protected function messages(): array
    {
        return [
            'uploads.*.file' => 'File tidak valid.',
            'uploads.*.mimes' => 'Format file harus PDF, JPG, atau PNG.',
            'uploads.*.max' => 'Ukuran file maksimal '.SpmbDokumen::MAX_SIZE_MB.' MB.',
        ];
    }

    public function uploadDokumen(string $jenis): void
    {
        $this->validate([
            "uploads.{$jenis}" => [
                'required',
                'file',
                'mimes:'.SpmbDokumen::ACCEPTED_EXTENSIONS,
                'max:'.(SpmbDokumen::MAX_SIZE_MB * 1024),
            ],
        ]);

        $pendaftar = Auth::user()->pendaftar;
        abort_unless($pendaftar, 403, 'Anda belum mendaftar.');

        $file = $this->uploads[$jenis];
        $path = $file->store("pendaftar-dokumen/{$pendaftar->id}", 'local');

        PendaftarDokumen::updateOrCreate(
            ['pendaftar_id' => $pendaftar->id, 'jenis' => $jenis],
            [
                'label' => SpmbDokumen::label($jenis),
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size_bytes' => $file->getSize(),
                'status' => 'menunggu',
                'catatan_verifikasi' => null,
                'verified_by' => null,
                'verified_at' => null,
            ]
        );

        unset($this->uploads[$jenis]);

        session()->flash('upload-success', 'Dokumen '.SpmbDokumen::label($jenis).' berhasil diunggah.');
    }

    public function deleteDokumen(int $id): void
    {
        $pendaftar = Auth::user()->pendaftar;
        $dokumen = PendaftarDokumen::where('pendaftar_id', $pendaftar->id)->findOrFail($id);

        Storage::disk('local')->delete($dokumen->path);
        $dokumen->delete();

        session()->flash('upload-success', 'Dokumen dihapus.');
    }

    public function render()
    {
        $pendaftar = Auth::user()->pendaftar;
        $required = SpmbDokumen::requiredForJalur($pendaftar->jalur_pendaftaran);
        $existing = $pendaftar->dokumens()->get()->keyBy('jenis');

        return view('livewire.upload-dokumen', [
            'pendaftar' => $pendaftar,
            'required' => $required,
            'existing' => $existing,
            'maxSizeMb' => SpmbDokumen::MAX_SIZE_MB,
        ]);
    }
}
