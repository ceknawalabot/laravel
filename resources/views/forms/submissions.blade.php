@extends('layouts.app')

@section('content')
    <h1>Pengiriman untuk Formulir: {{ $form->title }}</h1>

    @if ($submissions->isEmpty())
        <p>Tidak ada pengiriman ditemukan.</p>
    @else
        @foreach ($submissions as $submission)
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
                <h3>ID Pengiriman: {{ $submission->id }}</h3>
                <p>Dikirim Pada: {{ $submission->created_at->format('d F Y, H:i:s') }}</p>
                <h4>Data yang Dikirim:</h4>
                <ul>
                    @foreach ($form->form_schema as $field)
                        @php
                            $fieldName = $field['name'] ?? null;
                            $fieldLabel = $field['label'] ?? $fieldName;
                            $value = data_get($submission->submission_data, $fieldName, 'N/A');
                        @endphp
                        <li><strong>{{ $fieldLabel }}:</strong> {{ is_array($value) ? implode(', ', $value) : $value }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif
@endsection
