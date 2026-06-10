<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Clinic extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

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

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'clinic_id');
    }

    public function operationalExpenses()
    {
        return $this->hasMany(OperationalExpense::class, 'clinic_id');
    }

    public function isApproved(): bool
    {
        return $this->approval_status === self::STATUS_APPROVED && $this->is_approved;
    }

    public function isWorking(): bool
    {
        return $this->isApproved() && $this->is_active;
    }
}
