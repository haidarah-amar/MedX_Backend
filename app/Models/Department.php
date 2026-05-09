<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
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
    )->withPivot('clinic_id')->withTimestamps();
}
}
