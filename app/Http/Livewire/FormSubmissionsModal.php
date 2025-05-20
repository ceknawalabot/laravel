<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FormSubmission;

class FormSubmissionsModal extends Component
{
    public $formId;
    public $submissions = [];
    public $editingSubmission = null;
    public $editingData = [];

    public function mount($formId)
    {
        $this->formId = $formId;
        $this->loadSubmissions();
    }

    public function loadSubmissions()
    {
        $submissions = FormSubmission::where('form_id', $this->formId)
            ->latest()
            ->get();

        \Log::info('Form ID: ' . $this->formId);
        \Log::info('Submissions count: ' . $submissions->count());

        $this->submissions = $submissions->map(function ($submission) {
            $data = $submission->submission_data;
            \Log::info('Processing submission data:', ['data' => $data]);

            $formattedData = [];
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $formattedData[] = "$key: " . json_encode($value);
                    } else {
                        $formattedData[] = "$key: $value";
                    }
                }
            }
            return [
                'id' => $submission->id,
                'tanggal' => $submission->created_at->format('d F Y, H:i:s'),
                'data' => implode("<br>", $formattedData),
                'raw_data' => $data,
                'submission' => $submission
            ];
        });
    }

    public function startEdit($submissionId)
    {
        \Log::info('Starting edit for submission: ' . $submissionId);
        $submission = collect($this->submissions)->firstWhere('id', $submissionId);
        if ($submission) {
            \Log::info('Found submission, setting edit state');
            $this->editingSubmission = $submissionId;
            $this->editingData = $this->flattenData($submission['raw_data']);
            \Log::info('Edit data:', ['data' => $this->editingData]);
        }
    }

    public function flattenData(array $data, string $prefix = ''): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $newKey = $prefix === '' ? $key : $prefix . '.' . $key;
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenData($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }
        return $result;
    }

    public function unflattenData(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $keys = explode('.', $key);
            $temp = &$result;
            foreach ($keys as $innerKey) {
                if (!isset($temp[$innerKey]) || !is_array($temp[$innerKey])) {
                    $temp[$innerKey] = [];
                }
                $temp = &$temp[$innerKey];
            }
            $temp = $value;
        }
        return $result;
    }

    public function cancelEdit()
    {
        $this->editingSubmission = null;
        $this->editingData = [];
    }

    public function saveEdit()
    {
        \Log::info('Saving edit for submission: ' . $this->editingSubmission);
        \Log::info('Editing data:', ['data' => $this->editingData]);
        $submission = FormSubmission::find($this->editingSubmission);
        if ($submission) {
            $unflattenedData = $this->unflattenData($this->editingData);
            $submission->update([
                'submission_data' => $unflattenedData
            ]);
            $this->cancelEdit();
            $this->loadSubmissions();
        }
    }

    public function render()
    {
        return view('livewire.form-submissions-modal');
    }
}
