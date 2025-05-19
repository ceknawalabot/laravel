<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    // Show form by slug
    public function show($slug)
    {
        $form = Form::where('slug', $slug)->first();

        if (!$form) {
            abort(404, 'Form not found');
        }

        $formSchema = $form->form_schema;

        return view('forms.show', [
            'form' => $form,
            'formSchema' => $formSchema,
        ]);
    }

    // Handle form submission (POST)
    public function submit(Request $request, $slug)
    {
        \Log::info('Form submission started', ['slug' => $slug, 'request' => $request->all()]);

        $form = Form::where('slug', $slug)->first();

        if (!$form) {
            \Log::error('Form not found', ['slug' => $slug]);
            abort(404, 'Form not found');
        }

        // Bypass validation and save all input except _token
        $inputData = $request->except('_token');

        \Log::info('Request input', ['input' => $inputData]);

        $validatedData = $inputData;

        \Log::info('Validated form submission data', ['data' => $validatedData]);

        // Always create new submission for each form submission
        $data = [
            'form_id' => $form->id,
            'slug' => Str::random(16),
            'submission_data' => $validatedData,
        ];

        // Removed employee_id as it does not exist in form_submissions table

        $formSubmission = \App\Models\FormSubmission::create($data);
        \Log::info('Form submission created', ['submission_id' => $formSubmission->id]);

        \Log::info('Form submission finished', ['submission_id' => $formSubmission->id]);

        // Generate a new slug for the form to simulate "posting" or publishing
        $form->slug = Str::random(16);
        $form->save();

        return redirect()->route('form.thankyou');
    }

    // Thank you page after submission
    public function thankyou()
    {
        return view('forms.thankyou');
    }

    // HRD view submissions for a form
    public function viewSubmissions($formId)
    {
        $form = Form::findOrFail($formId);
        $submissions = $form->submissions()->with('employee')->get();

        return view('forms.submissions', [
            'form' => $form,
            'submissions' => $submissions,
        ]);
    }
}
