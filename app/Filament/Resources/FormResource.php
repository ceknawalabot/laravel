<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['submissions' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);
    }

    public static function form(Form $form): Form
    {
        $resolveFormId = function ($formId): ?int {
            if ($formId instanceof \Illuminate\Database\Eloquent\Builder || $formId instanceof \Illuminate\Database\Query\Builder) {
                $formModel = $formId->first();
                return $formModel ? $formModel->id : null;
            } elseif (is_string($formId)) {
                $formModel = \App\Models\Form::where('slug', $formId)->first();
                return $formModel ? $formModel->id : null;
            } elseif (is_int($formId)) {
                return $formId;
            }
            return null;
        };

        $formIdRaw = request()->route('record');
        $formId = $resolveFormId($formIdRaw);

        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->maxLength(65535),
                \App\Filament\Forms\Components\LivewireFormBuilder::make('form_schema')
                    ->label('Field Formulir')
                    ->columnSpan('full')
                    ->view('filament.forms.components.livewire-form-builder')
                    ->extraAttributes(['wire:key' => 'form-builder'])
                    ->formId($formId ?? 0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('form_url')
                    ->label('URL Formulir')
                    ->getStateUsing(function ($record) {
                        if ($record->slug) {
                            return url('/form/' . $record->slug);
                        }
                        return 'Tidak ada URL';
                    })
                    ->url(function ($record) {
                        if ($record->slug) {
                            return url('/form/' . $record->slug);
                        }
                        return null;
                    })
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d F Y, H:i:s')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view_submissions')
                    ->label('Lihat Kiriman')
                    ->icon('heroicon-m-eye')
                    ->modalContent(fn ($record) => view('filament.forms.modal.submissions', ['formId' => $record->id]))
                    ->modalHeading(fn ($record) => "Kiriman untuk: {$record->title}")
                    ->modalWidth('7xl')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}
