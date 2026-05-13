<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Doctor extends Model
{
    protected $fillable = [
        'serial_number',
        'name_en',
        'name_ar',
        'specialization_en',
        'specialization_ar',
        'birthdate',
        'id_passport',
        'photo',
        'hourly_rate',
        'working_hours',
        'department_id',
        'clinic_id',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    // public function departments()
    // {
    //     return $this->belongsToMany(Department::class, 'departments_doctors', 'doctor_id', 'department_id');
    // }

    public function departments()
{
    return $this->belongsToMany(
        Department::class,
        'departments_doctors'
    )->withPivot('clinic_id')->withTimestamps();
}

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($doctor) {
            do {
                $serial = 'MX' . strtoupper(Str::random(12));
            } while (self::whereSerialNumber($serial)->exists());

            $doctor->serial_number = $serial;
        });
    }
}


