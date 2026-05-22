<?php

namespace App\Livewire\Sekolah;

use App\Models\Sekolah;
use App\Services\JalurRecommender;
use Livewire\Attributes\Computed;
use Livewire\Component;

class RekomendasiJalur extends Component
{
    public Sekolah $sekolah;

    public array $answers = [];

    public bool $showResult = false;

    public function mount(Sekolah $sekolah): void
    {
        $this->sekolah = $sekolah;
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
