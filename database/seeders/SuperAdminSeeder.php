<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('SUPER_ADMIN_EMAIL', 'superadmin@medx.com')],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'phone_number' => '0912345678',
                'gender' => 'male',
                'birthdate' => null,
                'address' => null,
                'id_passport' => null,
                'password' => Hash::make(env('SUPER_ADMIN_PASSWORD', 'password')),
                'role' => User::ROLE_SUPER_ADMIN,
            ]
        );
    }
}
