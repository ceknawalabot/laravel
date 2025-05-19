<div>
    {{-- Form Builder UI --}}
    <h3>Pembuat Form Dinamis</h3>

    <div>
        <label for="title">Judul</label>
        <input type="text" id="title" wire:model="title" />
        @error('title') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="description">Deskripsi</label>
        <textarea id="description" wire:model="description"></textarea>
        @error('description') <span class="error">{{ $message }}</span> @enderror
    </div>

    <button type="button" wire:click="addField" class="bg-primary-600 text-gray-900 dark:text-white rounded px-4 py-2 hover:bg-primary-700 transition">Tambah Field</button>

    <ul>
        @foreach ($fields as $index => $field)
            <li>{{ $field['label'] ?? 'Field Tanpa Nama' }} ({{ $field['type'] ?? 'tidak diketahui' }})</li>
        @endforeach
    </ul>

    <button type="button" wire:click="createForm">Buat Form</button>

    @if (session()->has('message'))
        <div class="success-message">
            {{ session('message') }}
        </div>
    @endif
</div>
