<div>
    <form wire:submit="submit" class="space-y-8">
        {{ $this->form }}

        <div class="flex flex-col-reverse items-stretch gap-3 border-t border-ink-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-xs text-ink-500">
                Pastikan seluruh data sudah benar sebelum mengirim.
            </p>
            <button
                type="submit"
                class="group inline-flex items-center justify-center gap-2 rounded-md bg-ink-900 px-6 py-3 text-sm font-semibold text-paper shadow-soft hover:bg-ink-800 disabled:opacity-50"
                wire:loading.attr="disabled"
                wire:target="submit"
            >
                <svg
                    wire:loading
                    wire:target="submit"
                    class="-ml-1 h-4 w-4 animate-spin"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span>Kirim Pendaftaran</span>
                <svg class="h-3.5 w-3.5 transition group-hover:translate-x-0.5" wire:loading.remove wire:target="submit" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </button>
        </div>
    </form>

    <x-filament-actions::modals />
</div>
