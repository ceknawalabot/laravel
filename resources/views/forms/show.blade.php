@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow-md">
    <h1 class="text-3xl font-bold mb-4">{{ $form->title }}</h1>
    @if($form->description)
        <p class="mb-6 text-gray-700">{{ $form->description }}</p>
    @endif

    @if(session('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('form.submit', ['slug' => $form->slug]) }}" class="space-y-6" id="dynamicForm">
        @csrf

        @foreach ($formSchema as $field)
            <div>
                <label for="{{ $field['name'] ?? '' }}" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $field['label'] ?? '' }}
                </label>

                @php
                    $fieldName = $field['name'] ?? '';
                    $fieldType = $field['type'] ?? 'text';
                    $oldValue = old($fieldName);
                @endphp

                @if ($fieldType === 'text')
                    <input type="text" name="{{ $fieldName }}" id="{{ $fieldName }}" value="{{ $oldValue }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @elseif ($fieldType === 'textarea')
                    <textarea name="{{ $fieldName }}" id="{{ $fieldName }}" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $oldValue }}</textarea>
                @elseif ($fieldType === 'checkbox')
                    @php
                        $options = explode(',', $field['optionsString'] ?? '');
                    @endphp
                    <div class="space-x-4">
                        @foreach ($options as $option)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="{{ $fieldName }}[]" value="{{ trim($option) }}" class="form-checkbox text-indigo-600" />
                                <span class="ml-2 text-gray-700">{{ trim($option) }}</span>
                            </label>
                        @endforeach
                    </div>
                @elseif ($fieldType === 'radio')
                    @php
                        $options = explode(',', $field['optionsString'] ?? '');
                    @endphp
                    <div class="space-x-4">
                        @foreach ($options as $option)
                            <label class="inline-flex items-center">
                                <input type="radio" name="{{ $fieldName }}" value="{{ trim($option) }}" class="form-radio text-indigo-600" />
                                <span class="ml-2 text-gray-700">{{ trim($option) }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif

                @error($fieldName)
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Kirim
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('dynamicForm');
        form.addEventListener('submit', function () {
            // Optionally disable the submit button to prevent multiple submissions
            form.querySelector('button[type="submit"]').disabled = true;
        });
    });
</script>
@endsection
