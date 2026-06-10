<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\OperationalExpense;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       
        $this->call([
            DepartmentSeeder::class
        ]);

        $clinics =
            Clinic::factory()
            ->count(20)
            ->create();

       
        $doctors =
            Doctor::factory()
            ->count(300)
            ->create();

      
        $users =
            User::factory()
            ->count(500)
            ->create();

        
        $categories =
            DB::table('departments_categories')
            ->pluck('id');

        $departments = collect();

        foreach ($clinics as $clinic)
        {
            $count = rand(3,6);

            for ($i=0;$i<$count;$i++)
            {
                $departments->push(
                    Department::create([
                        'clinic_id' => $clinic->id,

                        'category_id' =>
                            $categories->random(),

                        'description_en' =>
                            fake()->sentence(),

                        'description_ar' =>
                            'قسم طبي متخصص'
                    ])
                );
            }
        }

        
        foreach ($departments as $department)
        {
            $selectedDoctors =
                $doctors->random(
                    rand(5,15)
                );

            foreach ($selectedDoctors as $doctor)
            {
                DB::table('departments_doctors')
                    ->insert([
                        'clinic_id' =>
                            $department->clinic_id,

                        'department_id' =>
                            $department->id,

                        'doctor_id' =>
                            $doctor->id,

                        'hourly_rate' =>
                            rand(20,150),

                        'created_at' =>
                            now(),

                        'updated_at' =>
                            now()
                    ]);
            }
        }

        
        for ($i=0;$i<2000;$i++)
        {
            $department =
                $departments->random();

            $doctor =
                DB::table('departments_doctors')
                ->where(
                    'department_id',
                    $department->id
                )
                ->inRandomOrder()
                ->first();

            $doctorCost =
                $doctor->hourly_rate;

            $clinic =
                $clinics->findOrFail(
                    $department->clinic_id
                );

            $fee =
                $doctorCost +
                (
                    $doctorCost *
                    $clinic->percentage /
                    100
                );

            Appointment::factory()
                ->create([

                    'user_id' =>
                        $users->random()->id,

                    'doctor_id' =>
                        $doctor->doctor_id,

                    'dep_id' =>
                        $department->id,

                    'clinic_id' =>
                        $clinic->id,

                    'doctor_cost' =>
                        $doctorCost,

                    'appointment_fee' =>
                        round($fee,2)
                ]);
        }

       
       $departments = Department::all();
       $clinics = Clinic::all();

        for ($i = 0; $i < 500; $i++)
        {
        if (rand(0,100) > 25)
         {
        $department = $departments->random();

        OperationalExpense::factory()
            ->create([
                'department_id' => $department->id,
                'clinic_id'     => $department->clinic_id,
            ]);
            }
        else
            {
        OperationalExpense::factory()
            ->create([
                'department_id' => null,
                'clinic_id'     => $clinics->random()->id,
            ]);
    }
}
} }