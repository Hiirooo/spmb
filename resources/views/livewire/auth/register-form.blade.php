<div>
    <form wire:submit="submit" class="space-y-6">
        {{ $this->form }}

        <button
            type="submit"
            class="group inline-flex w-full items-center justify-center gap-2 rounded-md bg-ink-900 px-6 py-3 text-sm font-semibold text-paper shadow-soft hover:bg-ink-800 disabled:opacity-50"
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
            <span>Buat Akun</span>
        </button>
    </form>

    <x-filament-actions::modals />
</div>
