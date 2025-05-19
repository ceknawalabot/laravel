<div class="dark:bg-gray-900 dark:text-white bg-white text-gray-900 p-4 rounded shadow">
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif
    <div class="mb-4">
        <label class="block font-bold mb-2">Judul Formulir</label>
        <input type="text" wire:model="title" class="border rounded w-full p-2 mb-4 dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Masukkan judul formulir" />
    </div>

    <div class="mb-4">
        <select wire:model="newFieldType" class="border rounded p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            <option value="text">Input Teks</option>
            <option value="textarea">Textarea</option>
            <option value="checkbox">Checklist</option>
            <option value="radio">Opsi Radio</option>
        </select>
        <button wire:click="addField" class="ml-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Tambah Field</button>
    </div>

    <div class="flex space-x-4">
        <div class="w-1/2 border p-4 rounded dark:border-gray-700">
            <h3 class="font-bold mb-2">Pembuat Formulir</h3>
            @foreach ($fields as $index => $field)
                <div class="mb-4 border p-2 rounded relative dark:border-gray-700">
                    <button wire:click="removeField({{ $index }})" class="absolute top-0 right-0 text-red-500 font-bold px-2">X</button>
                    <label class="block mb-1">Label Field</label>
                    <input type="text" wire:model="fields.{{ $index }}.label" class="border rounded w-full p-1 mb-2 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />

                    <label class="block mb-1">Nama Field</label>
                    <input type="text" wire:model="fields.{{ $index }}.name" class="border rounded w-full p-1 mb-2 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />

                    @if(in_array($field['type'], ['checkbox', 'radio']))
                        <label class="block mb-1">Opsi (pisahkan dengan koma)</label>
                        <input type="text" wire:model.lazy="fields.{{ $index }}.optionsString" class="border rounded w-full p-1 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    @endif
                </div>
            @endforeach
        </div>

        <div class="w-1/2 border p-4 rounded dark:border-gray-700">
            <h3 class="font-bold mb-2">Pratinjau Formulir</h3>
            @if($title)
                <h4 class="text-xl font-semibold mb-4">{{ $title }}</h4>
            @endif
            <form>
                @foreach ($fields as $field)
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">{{ $field['label'] }}</label>
                        @if($field['type'] === 'text')
                            <input type="text" class="border rounded w-full p-1 dark:bg-gray-800 dark:border-gray-700 dark:text-white" disabled />
                        @elseif($field['type'] === 'textarea')
                            <textarea class="border rounded w-full p-1 dark:bg-gray-800 dark:border-gray-700 dark:text-white" disabled></textarea>
                        @elseif($field['type'] === 'checkbox')
                            @foreach(explode(',', $field['optionsString'] ?? '') as $option)
                                <label class="inline-flex items-center mr-2">
                                    <input type="checkbox" disabled />
                                    <span class="ml-1">{{ trim($option) }}</span>
                                </label>
                            @endforeach
                        @elseif($field['type'] === 'radio')
                            @foreach(explode(',', $field['optionsString'] ?? '') as $option)
                                <label class="inline-flex items-center mr-2">
                                    <input type="radio" disabled />
                                    <span class="ml-1">{{ trim($option) }}</span>
                                </label>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </form>
            <div class="mt-4 flex space-x-4">
                <button wire:click="saveForm" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">Simpan Formulir</button>
            </div>
        </div>
    </div>
</div>
