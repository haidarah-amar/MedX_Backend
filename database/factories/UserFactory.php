<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [

            'first_name' =>
                fake()->firstName(),

            'last_name' =>
                fake()->lastName(),

            'email' =>
                fake()->unique()->safeEmail(),

            'phone_number' =>
                fake()->phoneNumber(),

            'gender' =>
                fake()->randomElement([
                    'male',
                    'female'
                ]),

            'birthdate' =>
                fake()->dateTimeBetween(
                    '-70 years',
                    '-18 years'
                ),

            'address' =>
                fake()->address(),

            'id_passport' =>
                strtoupper(
                    fake()->bothify('??######')
                ),

            'password' =>
                Hash::make('12345678')
        ];
    }
}