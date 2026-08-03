<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // SuperAdminSeeder::class,
            ClinicSeeder::class,

            DepartmentCategorySeeder::class,
            DepartmentSeeder::class,

            DoctorSeeder::class,
            DepartmentDoctorSeeder::class,

            UserSeeder::class,

            AppointmentSeeder::class,

            OperationalExpenseSeeder::class,
        ]);

           }
}
