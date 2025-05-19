@if (isset($record) && $record->google_form_url)
    <iframe src="{{ $record->google_form_url }}" width="100%" height="800" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
@else
    <p>Silakan berikan URL Google Form untuk disematkan.</p>
@endif
