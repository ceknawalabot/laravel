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
        'password',
        'phone',
        'department_id',
        'position_id',
        'date_of_birth',
        'date_of_hire',
        'address',
        'status',
        'bank',
        'account_number',
        'account_holder_name',
        'active_membership_date',
        'passport_expiry_date',
        'visa_expiry_date',
        'store_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if ($employee->password) {
                $employee->password = bcrypt($employee->password);
            }
        });

        static::updating(function ($employee) {
            if ($employee->isDirty('password') && $employee->password) {
                $employee->password = bcrypt($employee->password);
            }
        });
    }

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
