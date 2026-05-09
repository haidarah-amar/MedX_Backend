<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Clinic extends Authenticatable implements JWTSubject
{
    protected $guarded = [];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function images()
    {
        return $this->hasMany(ClinicImage::class, 'clinic_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'clinic_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'clinic_id');
    }

    public function doctors()
    {
        return $this->belongsToMany(
            Doctor::class,
            'clinic_doctor',
            'clinic_id',
            'doctor_id'
        )->withPivot('department_id')->withTimestamps();
    }
}
