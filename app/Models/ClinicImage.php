<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicImage extends Model
{
    protected $fillable = [
        'clinic_id',
        'image_path',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }
}
