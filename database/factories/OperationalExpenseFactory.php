<?php

namespace Database\Factories;

use App\Models\OperationalExpense;
use Illuminate\Database\Eloquent\Factories\Factory;

class OperationalExpenseFactory extends Factory
{
    protected $model = OperationalExpense::class;

    public function definition(): array
    {
        return [

            'clinic_id' => null,

            'category' => fake()->randomElement([
                'medical_supplies',
                'equipment_maintenance',
                'administrative'
            ]),

            'amount' => fake()->randomFloat(
                2,
                20,
                3000
            ),

            'description' => fake()->sentence(),

            'expense_date' => fake()->dateTimeBetween(
                '-12 months',
                'now'
            ),
        ];
    }
}