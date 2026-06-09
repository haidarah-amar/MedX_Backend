<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [

            'name_en' =>
                'Dr. '.$this->faker->name(),

            'name_ar' =>
                fake()->randomElement([
                    'د. أحمد',
                    'د. محمد',
                    'د. خالد',
                    'د. عمر',
                    'د. يوسف',
                    'د. علي'
                ]),

            'specialization_en' =>
                fake()->randomElement([
                    'Cardiology',
                    'Neurology',
                    'Radiology',
                    'Dermatology',
                    'Orthopedics',
                    'Dentistry',
                    'Pediatrics'
                ]),

            'specialization_ar' =>
                fake()->randomElement([
                    'قلبية',
                    'أعصاب',
                    'أشعة',
                    'جلدية',
                    'عظام',
                    'أسنان',
                    'أطفال'
                ]),

            'birthdate' =>
                fake()->dateTimeBetween(
                    '-60 years',
                    '-28 years'
                ),

            'id_passport' =>
                strtoupper(fake()->bothify('??######')),

            'photo' =>
                'doctors/default.jpg',

            'working_hours' =>
                fake()->numberBetween(4,10)
        ];
    }
}