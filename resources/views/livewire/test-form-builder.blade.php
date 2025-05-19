<div>
    <h2>Test Form Builder Component</h2>
    <select wire:model="newFieldType">
        <option value="text">Text</option>
        <option value="textarea">Textarea</option>
        <option value="checkbox">Checkbox</option>
        <option value="radio">Radio</option>
    </select>
    <button wire:click="addField">Add Field</button>

<ul>
    @foreach ($fields ?? [] as $index => $field)
        <li>
            Type: {{ $field['type'] }}
            <button wire:click="removeField({{ $index }})">Remove</button>
        </li>
    @endforeach
</ul>
</div>
