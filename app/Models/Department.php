<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    // use HasFactory;
    protected $guarded = [];
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    // public function doctors()
    // {
    //     return $this->belongsToMany(Doctor::class, 'departments_doctors', 'department_id', 'doctor_id');
    // }

    public function doctors()
    {
        return $this->belongsToMany(
            Doctor::class,
            'departments_doctors'
        )->withPivot('clinic_id', 'hourly_rate')->withTimestamps();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'dep_id');
    }
}
