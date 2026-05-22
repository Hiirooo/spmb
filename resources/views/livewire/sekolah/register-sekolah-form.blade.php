<div>
    <form wire:submit="submit" class="space-y-8">
        {{ $this->form }}

        <div class="flex flex-col-reverse items-stretch gap-3 border-t border-ink-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-xs text-ink-500">
                Setelah terdaftar, sekolah Anda dapat langsung menerima pendaftaran calon siswa.
            </p>
            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-ink-900 px-6 py-3 text-sm font-semibold text-paper shadow-soft hover:bg-ink-800 disabled:opacity-50"
                wire:loading.attr="disabled"
                wire:target="submit"
            >
                <svg wire:loading wire:target="submit" class="-ml-1 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                Daftarkan Sekolah
            </button>
        </div>
    </form>

    <x-filament-actions::modals />
</div>
