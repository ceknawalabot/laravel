<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateForm extends CreateRecord
{
    protected static string $resource = FormResource::class;

    public function getView(): string
    {
        return 'filament.forms.create-form';
    }
}

