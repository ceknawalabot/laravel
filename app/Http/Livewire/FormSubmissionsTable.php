<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FormSubmission;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;

class FormSubmissionsTable extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    public $formId;
    public $isVisible = false;

    public function mount($formId)
    {
        $this->formId = $formId;
    }

    protected function getTableQuery(): Builder
    {
        return FormSubmission::query()
            ->where('form_id', $this->formId)
            ->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('created_at')
                ->label('Tanggal')
                ->dateTime('d F Y, H:i:s')
                ->sortable(),
            TextColumn::make('data')
                ->label('Data')
                ->formatStateUsing(function ($state) {
                    $data = json_decode($state, true);
                    if (!$data) return '-';
                    
                    $formatted = [];
                    foreach ($data as $key => $value) {
                        $formatted[] = "$key: $value";
                    }
                    return implode("<br>", $formatted);
                })
                ->html(),
        ];
    }

    public function toggleVisibility()
    {
        $this->isVisible = !$this->isVisible;
    }

    public function render()
    {
        return view('livewire.form-submissions-table');
    }
}
