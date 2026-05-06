<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $guarded = [];

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'departments_doctors', 'doctor_id', 'department_id');
    }
}
