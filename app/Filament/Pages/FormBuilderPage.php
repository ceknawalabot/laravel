<?php

// Disabled FormBuilderPage to prevent Livewire missing root tag error

namespace App\Filament\Pages;

use Filament\Pages\Page;

class FormBuilderPage extends Page
{
    protected static ?string $navigationIcon = null;

    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.form-builder-page-no-sidebar';

    protected static ?string $title = null;

    protected static ?string $navigationLabel = null;

    protected static ?string $slug = null;
}
