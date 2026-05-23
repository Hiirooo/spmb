<div>
    @if(session('upload-success'))
        <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('upload-success') }}
        </div>
    @endif

    @if(! empty($validationErrors))
        <div class="mb-6 rounded-md border border-amber-200 bg-amber-50 px-4 py-4">
            <p class="text-sm font-semibold text-amber-800">⚠ Persyaratan dokumen jalur {{ ucfirst($pendaftar->jalur_pendaftaran) }} belum lengkap:</p>
            <ul class="mt-2 list-disc pl-5 space-y-1 text-sm text-amber-700">
                @foreach($validationErrors as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @else
        @if($existing->isNotEmpty())
            <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                ✓ Seluruh dokumen wajib jalur {{ ucfirst($pendaftar->jalur_pendaftaran) }} telah lengkap. Tunggu verifikasi tim sekolah.
            </div>
        @endif
    @endif

    <div class="space-y-4">
        @foreach($required as $req)
            @php
                $jenis = $req['jenis'];
                $isOptional = \App\Support\SpmbDokumen::isOptional($jenis, $pendaftar->jalur_pendaftaran);
                $doc = $existing[$jenis] ?? null;
                $statusBadge = match($doc?->status) {
                    'diterima' => ['bg-emerald-50 text-emerald-700 ring-emerald-200', 'Diverifikasi'],
                    'ditolak' => ['bg-rose-50 text-rose-700 ring-rose-200', 'Ditolak'],
                    'menunggu' => ['bg-amber-50 text-amber-700 ring-amber-200', 'Menunggu Verifikasi'],
                    default => null,
                };
            @endphp

            <div class="rounded-lg border border-ink-200 bg-white p-5 shadow-soft">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="font-serif text-base font-semibold text-ink-900">{{ $req['label'] }}</h3>
                            @if($isOptional)
                                <span class="inline-flex items-center rounded-full bg-ink-100 px-2 py-0.5 text-[10px] font-medium uppercase tracking-wide text-ink-600">Opsional</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-[10px] font-medium uppercase tracking-wide text-rose-700">Wajib</span>
                            @endif
                            @if($statusBadge)
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold ring-1 {{ $statusBadge[0] }}">{{ $statusBadge[1] }}</span>
                            @endif
                        </div>
                        <p class="mt-1 text-xs text-ink-500">{{ $req['desc'] }}</p>
                        @if($doc)
                            <div class="mt-3 flex flex-wrap items-center gap-3 text-xs">
                                <span class="font-medium text-ink-700">{{ $doc->original_name }}</span>
                                <span class="text-ink-400">{{ $doc->size_formatted }}</span>
                                <a href="{{ route('portal.dokumen.preview', ['dokumen' => $doc->id]) }}" target="_blank" class="font-medium text-ink-900 underline-offset-4 hover:underline">Lihat</a>
                                @if($doc->status !== 'diterima')
                                    <button type="button" wire:click="deleteDokumen({{ $doc->id }})" wire:confirm="Hapus dokumen ini?" class="text-rose-600 hover:underline">Hapus</button>
                                @endif
                            </div>
                            @if($doc->catatan_verifikasi)
                                <p class="mt-2 rounded-md bg-paper px-3 py-2 text-xs leading-relaxed text-ink-700">
                                    <span class="font-semibold">Catatan admin:</span> {{ $doc->catatan_verifikasi }}
                                </p>
                            @endif
                        @endif
                    </div>

                    @if(! $doc || $doc->status !== 'diterima')
                        <div class="flex flex-col gap-2 sm:w-64">
                            <input type="file"
                                wire:model="uploads.{{ $jenis }}"
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="block w-full text-xs file:mr-3 file:rounded-md file:border-0 file:bg-ink-900 file:px-3 file:py-2 file:text-xs file:font-medium file:text-paper hover:file:bg-ink-800" />
                            @if(isset($uploads[$jenis]) && $uploads[$jenis])
                                <button type="button"
                                    wire:click="uploadDokumen('{{ $jenis }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="uploadDokumen('{{ $jenis }}'),uploads.{{ $jenis }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-md bg-ink-900 px-3 py-2 text-xs font-semibold text-paper hover:bg-ink-800 disabled:opacity-50">
                                    <svg wire:loading wire:target="uploadDokumen('{{ $jenis }}')" class="-ml-1 h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    Unggah
                                </button>
                            @endif
                            @error("uploads.{$jenis}")
                                <p class="text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                            <p class="text-[10px] text-ink-400">PDF/JPG/PNG · maks {{ $maxSizeMb }} MB</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
