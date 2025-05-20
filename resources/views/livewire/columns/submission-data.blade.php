<div class="space-y-2">
    @foreach ($getRecord()->submission_data as $key => $value)
        <div>
            <span class="font-medium">{{ $key }}:</span>
            <span>{{ is_array($value) ? implode(', ', $value) : $value }}</span>
        </div>
    @endforeach
</div>
