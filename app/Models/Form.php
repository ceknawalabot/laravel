<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'form_schema', // JSON schema for the form fields
    ];

    protected $casts = [
        'form_schema' => 'array',
    ];

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }
}
