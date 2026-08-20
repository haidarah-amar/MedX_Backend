<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'clinic_id',
        'image_path',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }
}
