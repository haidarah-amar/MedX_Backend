<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentCategory extends Model
{
    use HasFactory;
    protected $table = 'departments_categories';

    protected $fillable = [
        'category',
        'name_en',
        'name_ar',
    ];
}
