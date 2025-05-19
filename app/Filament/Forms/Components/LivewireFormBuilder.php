<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class LivewireFormBuilder extends Field
{
    protected string $view = 'filament.forms.components.livewire-form-builder';

    protected ?int $formId = null;

    public function formId(mixed $formId): static
    {
        if ($formId instanceof \Illuminate\Database\Eloquent\Builder || $formId instanceof \Illuminate\Database\Query\Builder) {
            $first = $formId->first();
            $formId = $first ? $first->id : null;
        } elseif (is_string($formId)) {
            // Optionally handle string to int conversion if needed
            $formId = null;
        } elseif (!is_int($formId)) {
            $formId = null;
        }
        $this->formId = $formId;
        return $this;
    }

    public function getLivewireComponent(): string
    {
        return 'form-builder';
    }

    protected function getViewData(): array
    {
        $formId = $this->formId;

        if (!is_int($formId)) {
            $formId = null;
        }

        return [
            'livewireComponent' => $this->getLivewireComponent(),
            'formId' => $formId,
        ];
    }
}
