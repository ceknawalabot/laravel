<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class FormBuilder extends Field
{
    protected string $view = 'filament.forms.components.form-builder';

    // Add properties and methods to manage form fields dynamically
    protected array $fields = [];

    public function addField(array $field): void
    {
        $this->fields[] = $field;
        $this->emit('formBuilderUpdated', $this->fields);
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    protected function getViewData(): array
    {
        return [
            'fields' => $this->fields,
        ];
    }
}
