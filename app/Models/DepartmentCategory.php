<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentCategory extends Model
{
    protected $table = 'departments_categories';

    protected $fillable = [
        'category',
        'name_en',
        'name_ar',
    ];
}
