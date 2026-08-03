<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentDoctorSeeder extends Seeder
{
    public function run(): void
    {
        $relations = [
            // المركز 1 - القسم 1
            [
                'clinic_id' => 1,
                'department_id' => 1,
                'doctor_id' => 1,
                'hourly_rate' => 80.50,
                'start_time' => '08:00:00',
                'end_time' => '15:00:00',
            ],
            [
                'clinic_id' => 1,
                'department_id' => 1,
                'doctor_id' => 2,
                'hourly_rate' => 60.22,
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
            ],

            // المركز 1 - القسم 2
            [
                'clinic_id' => 1,
                'department_id' => 2,
                'doctor_id' => 3,
                'hourly_rate' => 75.00,
                'start_time' => '08:00:00',
                'end_time' => '14:00:00',
            ],
            [
                'clinic_id' => 1,
                'department_id' => 2,
                'doctor_id' => 4,
                'hourly_rate' => 70.00,
                'start_time' => '14:00:00',
                'end_time' => '20:00:00',
            ],

            // المركز 1 - القسم 3
            [
                'clinic_id' => 1,
                'department_id' => 3,
                'doctor_id' => 5,
                'hourly_rate' => 90.00,
                'start_time' => '09:00:00',
                'end_time' => '14:00:00',
            ],
            [
                'clinic_id' => 1,
                'department_id' => 3,
                'doctor_id' => 6,
                'hourly_rate' => 85.00,
                'start_time' => '14:00:00',
                'end_time' => '19:00:00',
            ],

            // المركز 2 - القسم 4
            [
                'clinic_id' => 2,
                'department_id' => 4,
                'doctor_id' => 7,
                'hourly_rate' => 100.00,
                'start_time' => '08:00:00',
                'end_time' => '14:00:00',
            ],
            [
                'clinic_id' => 2,
                'department_id' => 4,
                'doctor_id' => 8,
                'hourly_rate' => 95.00,
                'start_time' => '14:00:00',
                'end_time' => '20:00:00',
            ],

            // المركز 2 - القسم 5
            [
                'clinic_id' => 2,
                'department_id' => 5,
                'doctor_id' => 9,
                'hourly_rate' => 85.00,
                'start_time' => '08:00:00',
                'end_time' => '15:00:00',
            ],
            [
                'clinic_id' => 2,
                'department_id' => 5,
                'doctor_id' => 10,
                'hourly_rate' => 80.00,
                'start_time' => '13:00:00',
                'end_time' => '19:00:00',
            ],

            // المركز 2 - القسم 6
            [
                'clinic_id' => 2,
                'department_id' => 6,
                'doctor_id' => 11,
                'hourly_rate' => 70.00,
                'start_time' => '09:00:00',
                'end_time' => '14:00:00',
            ],
            [
                'clinic_id' => 2,
                'department_id' => 6,
                'doctor_id' => 12,
                'hourly_rate' => 75.00,
                'start_time' => '14:00:00',
                'end_time' => '19:00:00',
            ],

            // المركز 3 - القسم 7
            [
                'clinic_id' => 3,
                'department_id' => 7,
                'doctor_id' => 13,
                'hourly_rate' => 95.00,
                'start_time' => '08:00:00',
                'end_time' => '14:00:00',
            ],
            [
                'clinic_id' => 3,
                'department_id' => 7,
                'doctor_id' => 14,
                'hourly_rate' => 100.00,
                'start_time' => '14:00:00',
                'end_time' => '20:00:00',
            ],

            // المركز 3 - القسم 8
            [
                'clinic_id' => 3,
                'department_id' => 8,
                'doctor_id' => 15,
                'hourly_rate' => 80.00,
                'start_time' => '08:00:00',
                'end_time' => '13:00:00',
            ],
            [
                'clinic_id' => 3,
                'department_id' => 8,
                'doctor_id' => 16,
                'hourly_rate' => 85.00,
                'start_time' => '13:00:00',
                'end_time' => '18:00:00',
            ],

            // المركز 3 - القسم 9
            [
                'clinic_id' => 3,
                'department_id' => 9,
                'doctor_id' => 17,
                'hourly_rate' => 90.00,
                'start_time' => '08:00:00',
                'end_time' => '14:00:00',
            ],
            [
                'clinic_id' => 3,
                'department_id' => 9,
                'doctor_id' => 18,
                'hourly_rate' => 95.00,
                'start_time' => '14:00:00',
                'end_time' => '20:00:00',
            ],
        ];

        foreach ($relations as $relation) {
            DB::table('departments_doctors')->updateOrInsert(
                [
                    'clinic_id' => $relation['clinic_id'],
                    'department_id' => $relation['department_id'],
                    'doctor_id' => $relation['doctor_id'],
                ],
                [
                    'hourly_rate' => $relation['hourly_rate'],
                    'start_time' => $relation['start_time'],
                    'end_time' => $relation['end_time'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}