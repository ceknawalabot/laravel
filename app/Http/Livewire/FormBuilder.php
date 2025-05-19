<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Support\Str;

class FormBuilder extends Component
{
    public $fields = [];

    public $newFieldType = 'text';

    public $title = '';
    public $description = '';

    public $formId;

    public function mount($formId = null)
    {
        $this->formId = $formId;

        if ($this->formId) {
            $form = Form::find($this->formId);
            if ($form) {
                $this->title = $form->title;
                $this->description = $form->description;
                $this->fields = $form->form_schema ?? [];
            }
        }
    }

    public function addField()
    {
        $this->fields[] = [
            'type' => $this->newFieldType,
            'label' => '',
            'name' => '',
            'optionsString' => '', // for checklist and radio options as comma separated string
        ];
    }

    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
    }

    public function saveForm()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fields' => 'array',
        ]);

        if ($this->formId) {
            $form = Form::find($this->formId);
            if ($form) {
                $form->title = $this->title;
                $form->description = $this->description;
                $form->form_schema = $this->fields;
                $form->save();

                session()->flash('message', 'Form berhasil diperbarui.');
            }
        } else {
            $slug = Str::slug($this->title) . '-' . Str::random(6);

            $form = Form::create([
                'title' => $this->title,
                'description' => $this->description,
                'form_schema' => $this->fields,
                'slug' => $slug,
            ]);

            session()->flash('message', 'Form berhasil dibuat.');

            $this->formId = $form->id;
        }
    }

    public function postForm()
    {
        // Validate form fields before posting
        $this->validate([
            'title' => 'required|string|max:255',
            'fields' => 'array',
        ]);

        if (!$this->formId) {
            session()->flash('error', 'Silakan simpan formulir sebelum memposting.');
            return;
        }

        // Create a new form submission with empty or default values
        $submissionData = [];
        foreach ($this->fields as $field) {
            $submissionData[$field['name']] = null; // or default value
        }

        $slug = Str::slug($this->title) . '-' . Str::random(6);

        FormSubmission::create([
            'form_id' => $this->formId,
            'submission_data' => $submissionData,
            'slug' => $slug,
        ]);

        session()->flash('message', 'Form berhasil diposting.');
    }

    public function render()
    {
        return view('livewire.form-builder');
    }
}
