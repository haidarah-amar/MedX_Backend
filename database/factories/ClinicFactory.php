<?php

namespace Database\Factories;

use App\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ClinicFactory extends Factory
{
    protected $model = Clinic::class;

    public function definition(): array
    {
        return [

            'email' => fake()->unique()->safeEmail(),

            'password' => Hash::make('12345678'),

            'name_en' =>
                fake()->company().' Medical Center',

            'name_ar' =>
                'مركز '.fake()->randomElement([
                    'الشفاء',
                    'الحياة',
                    'الأمل',
                    'السلام',
                    'الرحمة',
                    'النور'
                ]),

            'owner_name' =>
                fake()->name(),

            'owner_idphoto' =>
                fake()->uuid(),

            'description_en' =>
                fake()->paragraph(),

            'description_ar' =>
                'مركز طبي متعدد الاختصاصات يقدم خدمات صحية متكاملة.',

            'location_en' =>
                fake()->city(),

            'location_ar' =>
                fake()->randomElement([
                    'دمشق',
                    'حلب',
                    'حمص',
                    'اللاذقية',
                    'طرطوس'
                ]),

            'phone_number' =>
                fake()->phoneNumber(),

            'working_hours' =>
                fake()->numberBetween(8,12),

            'percentage' =>
                fake()->randomFloat(
                    2,
                    10,
                    35
                ),

            'is_approved' => true,

            'is_active' => true,

            'latitude' =>
                fake()->latitude(),

            'longitude' =>
                fake()->longitude()
        ];
    }
}