<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalExpense extends Model
{
    use HasFactory;
    protected $fillable = [
        'clinic_id',
        'category',
        'amount',
        'department_id',
        'description',
        'expense_date'
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}