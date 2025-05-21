<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Log;

class FormSubmissionsModal extends Component
{
    public $formId;
    public $submissions = [];
    public $editingSubmission = null;
    public $editingDataPublic = [];
    public $originalData = [];

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

        $this->submissions = $submissions->map(function ($submission) {
            $data = $submission->submission_data;
            $dataToFormat = is_array($data) && isset($data['data']) ? $data['data'] : (is_array($data) ? $data : []);

            $formattedData = [];
            foreach ($dataToFormat as $key => $value) {
                $formattedData[] = is_array($value) ? "$key: " . json_encode($value) : "$key: $value";
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

    public function loadEditData($submissionId)
    {
        $this->editingSubmission = $submissionId;
        $submission = collect($this->submissions)->firstWhere('id', $submissionId);
        
        if ($submission) {
            $rawData = $submission['raw_data'];
            $this->editingDataPublic = $this->flattenData(
                isset($rawData['data']) ? $rawData['data'] : $rawData
            );
            $this->originalData = $rawData;
        }
    }

    public function flattenData(array $data, string $prefix = ''): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $newKey = $prefix ? $prefix . '_' . $key : $key;
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
            $keys = explode('_', $key);
            $temp = &$result;
            foreach ($keys as $innerKey) {
                if (!isset($temp[$innerKey])) {
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
        $this->editingDataPublic = [];
        $this->originalData = [];
    }

    public function saveEdit()
    {
        if ($this->editingSubmission) {
            $submission = FormSubmission::find($this->editingSubmission);
            if ($submission) {
                $submission->update([
                    'submission_data' => $this->unflattenData($this->editingDataPublic)
                ]);
                $this->cancelEdit();
                $this->loadSubmissions();
            }
        }
    }

    public function deleteSubmission($submissionId)
    {
        $submission = FormSubmission::find($submissionId);
        if ($submission) {
            try {
                $submission->delete();
                $this->loadSubmissions();
            } catch (\Exception $e) {
                // Log error or handle as needed
                \Log::error("Failed to delete submission ID {$submissionId}: " . $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.form-submissions-modal');
    }
}
