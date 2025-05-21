<div class="space-y-4">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Data
                    </th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($submissions as $submission)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $submission['tanggal'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                            @if ($editingSubmission == $submission['id'])

                                <div class="space-y-4">
                                    @foreach($editingDataPublic as $key => $value)
                                        <div class="flex flex-col space-y-1">
                                            <label class="text-sm font-medium">{{ str_replace('_', ' > ', $key) }}</label>
                                            <input type="text" 
                                                wire:model.lazy="editingDataPublic.{{ $key }}" 
                                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                                        </div>
                                    @endforeach
                                    <div class="flex space-x-2 mt-4">
                                        <button type="button" wire:click="saveEdit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            Simpan
                                        </button>
                                        <button type="button" wire:click="cancelEdit" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            @else
                                {!! $submission['data'] !!}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            @if ($editingSubmission != $submission['id'])

                                <button type="button" wire:click="loadEditData({{ $submission['id'] }})" 
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    Edit
                                </button>
                                <button type="button" wire:click="deleteSubmission({{ $submission['id'] }})" onclick="return confirm('Apakah Anda yakin ingin menghapus submission ini?')" 
                                    class="ml-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    Hapus
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            Belum ada kiriman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
