<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'dep_id',
        'date',
        'time',
        'is_asap',
        'status',
        'user_notes',
        'doctor_notes',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'is_asap' => 'boolean',
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

}
