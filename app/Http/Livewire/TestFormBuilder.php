<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TestFormBuilder extends Component
{
    public $fields = [];

    public $newFieldType = 'text';

    public function addField()
    {
        $this->fields[] = [
            'type' => $this->newFieldType,
            'label' => '',
            'name' => '',
            'optionsString' => '',
        ];
    }

    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
    }

    public function render()
    {
        return view('livewire.test-form-builder');
    }
}
