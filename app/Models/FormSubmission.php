<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'employee_id',
        'submission_data', // JSON data of the form submission
        'slug',
    ];

    protected $casts = [
        'submission_data' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
