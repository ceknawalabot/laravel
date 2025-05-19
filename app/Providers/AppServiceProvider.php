<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\TestFormBuilder;
use App\Http\Livewire\FormBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('test-form-builder', TestFormBuilder::class);
        Livewire::component('form-builder', FormBuilder::class);
    }
}
