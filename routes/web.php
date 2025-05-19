<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::get('/form/thankyou', [FormController::class, 'thankyou'])->name('form.thankyou');

Route::prefix('form')->group(function () {
    Route::get('/submissions/{formId}', [FormController::class, 'viewSubmissions'])->name('form.submissions');
    Route::get('/{slug}', [FormController::class, 'show'])->name('form.show');
    Route::post('/{slug}', [FormController::class, 'submit'])->name('form.submit');
});

// New test route for form builder with formId parameter
Route::get('/test-form-builder/{formId?}', function ($formId = null) {
    return view('test-form-builder-wrapper', ['formId' => $formId]);
})->name('test.form.builder');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-livewire', function () {
    return view('test-livewire');
});

Route::get('/test-form-builder', function () {
    return view('test-form-builder-wrapper');
});
