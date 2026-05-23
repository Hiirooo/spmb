<?php

namespace App\Livewire\Sekolah;

use App\Models\Sekolah;
use App\Services\Geocoder;
use App\Services\JalurRecommender;
use Livewire\Attributes\Computed;
use Livewire\Component;

class RekomendasiJalur extends Component
{
    public Sekolah $sekolah;

    public array $answers = [];

    public bool $showResult = false;

    public string $alamatLengkap = '';

    public ?float $jarakKm = null;

    public ?string $alamatHasilGeocode = null;

    public bool $cekJarakLoading = false;

    public ?string $cekJarakError = null;

    public function mount(Sekolah $sekolah): void
    {
        $this->sekolah = $sekolah;
    }

    public function cekJarak(): void
    {
        $this->cekJarakError = null;
        $this->jarakKm = null;
        $this->alamatHasilGeocode = null;

        if (strlen(trim($this->alamatLengkap)) < 5) {
            $this->cekJarakError = 'Masukkan alamat yang lebih spesifik (minimal 5 karakter), atau koordinat "lat, lng".';
            return;
        }

        if (! $this->sekolah->latitude || ! $this->sekolah->longitude) {
            $this->cekJarakError = 'Sekolah ini belum memiliki data koordinat.';
            return;
        }

        $coords = $this->parseCoordinates($this->alamatLengkap);

        if ($coords !== null) {
            $this->jarakKm = $this->sekolah->distanceKmFrom($coords['lat'], $coords['lng']);
            $this->alamatHasilGeocode = sprintf('Koordinat: %.6f, %.6f', $coords['lat'], $coords['lng']);
        } else {
            $result = Geocoder::search($this->alamatLengkap);
            if (! $result) {
                $this->cekJarakError = 'Alamat tidak ditemukan. Coba tambahkan nama jalan atau kelurahan, atau gunakan koordinat (contoh: -3.009556, 104.818746).';
                return;
            }

            $this->jarakKm = $this->sekolah->distanceKmFrom($result['lat'], $result['lng']);
            $this->alamatHasilGeocode = $result['display_name'] ?? null;
        }

        if ($this->jarakKm !== null) {
            $this->answers['jarak_sekolah'] = match (true) {
                $this->jarakKm < 3 => '< 3 km',
                $this->jarakKm <= 10 => '3-10 km',
                default => '> 10 km',
            };
        }
    }

    private function parseCoordinates(string $input): ?array
    {
        $cleaned = trim($input);
        if (! preg_match('/^\s*(-?\d+(?:\.\d+)?)\s*[,;\s]\s*(-?\d+(?:\.\d+)?)\s*$/', $cleaned, $m)) {
            return null;
        }

        $lat = (float) $m[1];
        $lng = (float) $m[2];

        if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
            return null;
        }

        return ['lat' => $lat, 'lng' => $lng];
    }

    public function submit(): void
    {
        $this->validate(
            collect(JalurRecommender::QUESTIONS)
                ->mapWithKeys(fn ($q, $key) => ["answers.{$key}" => 'required'])
                ->all(),
            attributes: collect(JalurRecommender::QUESTIONS)
                ->mapWithKeys(fn ($q, $key) => ["answers.{$key}" => $q['label']])
                ->all()
        );

        session()->put('rekomendasi_answers.'.$this->sekolah->slug, $this->answers);
        $this->showResult = true;
    }

    public function ulangi(): void
    {
        $this->answers = [];
        $this->showResult = false;
        $this->jarakKm = null;
        $this->alamatLengkap = '';
        $this->alamatHasilGeocode = null;
        $this->cekJarakError = null;
        session()->forget('rekomendasi_answers.'.$this->sekolah->slug);
    }

    #[Computed]
    public function result(): array
    {
        return JalurRecommender::score($this->answers);
    }

    public function lanjutkanPendaftaran(string $jalur): mixed
    {
        session()->put('jalur_rekomendasi.'.$this->sekolah->slug, $jalur);
        return redirect()->route('sekolah.daftar', ['sekolah' => $this->sekolah->slug, 'jalur' => $jalur]);
    }

    public function render()
    {
        return view('livewire.sekolah.rekomendasi-jalur', [
            'questions' => JalurRecommender::QUESTIONS,
        ]);
    }
}
