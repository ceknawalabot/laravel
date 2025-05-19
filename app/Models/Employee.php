<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'department_id',
        'position_id',
        'date_of_birth',
        'date_of_hire',
        'address',
        'status',
        'bank',
        'account_number',
        'active_membership_date',
        'passport_expiry_date',
        'visa_expiry_date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
