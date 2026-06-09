<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [

            'date' => fake()->dateTimeBetween(
                '-12 months',
                'now'
            ),

            'time' => fake()->dateTimeBetween(
                '-12 months',
                'now'
            ),

            'status' => fake()->randomElement([
                'completed',
                'completed',
                'completed',
                'completed',
                'booked',
                'canceled'
            ]),

            'is_asap' => fake()->boolean(10),

            'user_notes' => fake()->sentence(),

            'doctor_notes' => fake()->sentence(),

            'is_returning' => fake()->boolean(40)
        ];
    }
}