<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'doctor_id',
        'dep_id',
        'clinic_id',
        'date',
        'time',
        'is_asap',
        'status',
        'user_notes',
        'doctor_notes',
        'appointment_fee',
        'is_returning',
        'doctor_cost',
        'rating',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'is_asap' => 'boolean',
        'rating' => 'decimal:2',
    ];

    // ─── Relationships ───────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

}
