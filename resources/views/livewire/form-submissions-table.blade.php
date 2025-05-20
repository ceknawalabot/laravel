<div>
    <div class="mb-4">
        <button wire:click="toggleVisibility" class="text-primary-600 hover:text-primary-500">
            {{ $isVisible ? 'Sembunyikan Kiriman' : 'Lihat Kiriman' }}
        </button>
    </div>

    @if($isVisible)
        <div class="border rounded-lg overflow-hidden">
            {{ $this->table }}
        </div>
    @endif
</div>
