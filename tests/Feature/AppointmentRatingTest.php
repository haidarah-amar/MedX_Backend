<?php

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\DB;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('stores the appointment rating and refreshes hierarchy ratings', function () {
    $clinic = Clinic::create([
        'email' => 'clinic@example.com',
        'password' => bcrypt('secret'),
        'name_en' => 'Clinic',
        'name_ar' => 'عيادة',
        'owner_name' => 'Owner',
        'owner_idphoto' => 'owner.jpg',
        'description_en' => 'Test clinic',
        'description_ar' => 'عيادة اختبار',
        'location_ar' => 'الرياض',
        'location_en' => 'Riyadh',
        'phone_number' => '0500000000',
        'is_approved' => true,
        'is_active' => true,
        'percentage' => 10,
    ]);

    DB::table('departments_categories')->insert([
        'id' => 1,
        'category' => 'general',
        'name_en' => 'General',
        'name_ar' => 'عام',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $department = Department::create([
        'clinic_id' => $clinic->id,
        'category_id' => 1,
        'description_en' => 'General',
        'description_ar' => 'عام',
        'location_ar' => 'الرياض',
        'location_en' => 'Riyadh',
    ]);

    $doctor = Doctor::create([
        'serial_number' => 'MXTEST123456',
        'name_en' => 'Doctor',
        'name_ar' => 'طبيب',
        'specialization_en' => 'Cardiology',
        'specialization_ar' => 'أمراض قلب',
        'birthdate' => '1990-01-01',
        'id_passport' => 'ABC123',
        'photo' => 'doctor.jpg',
        'working_hours' => 8,
    ]);

    DB::table('departments_doctors')->insert([
        'clinic_id' => $clinic->id,
        'department_id' => $department->id,
        'doctor_id' => $doctor->id,
        'hourly_rate' => 100,
        'start_time' => '08:00:00',
        'end_time' => '17:00:00',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $user = User::factory()->create();

    $appointment = Appointment::create([
        'user_id' => $user->id,
        'doctor_id' => $doctor->id,
        'dep_id' => $department->id,
        'clinic_id' => $clinic->id,
        'date' => '2026-08-20',
        'time' => '2026-08-20 10:00:00',
        'appointment_fee' => 100,
        'doctor_cost' => 80,
        'status' => 'completed',
        'rating' => null,
    ]);

    $repository = app(AppointmentRepository::class);

    $repository->refreshRatingHierarchy($appointment, ['rating' => 4.5]);

    expect((float) $appointment->fresh()->rating)->toBe(4.5)
        ->and((float) $doctor->fresh()->rating)->toBe(4.5)
        ->and((float) $department->fresh()->rating)->toBe(4.5)
        ->and((float) $clinic->fresh()->rating)->toBe(4.5);
});

it('rejects a rating update when the rating field is missing', function () {
    $user = User::factory()->create();
    $clinic = Clinic::create([
        'email' => 'clinic2@example.com',
        'password' => bcrypt('secret'),
        'name_en' => 'Clinic 2',
        'name_ar' => 'عيادة 2',
        'owner_name' => 'Owner 2',
        'owner_idphoto' => 'owner2.jpg',
        'description_en' => 'Another clinic',
        'description_ar' => 'عيادة أخرى',
        'location_ar' => 'جدة',
        'location_en' => 'Jeddah',
        'phone_number' => '0500000001',
        'is_approved' => true,
        'is_active' => true,
        'percentage' => 10,
    ]);

    DB::table('departments_categories')->insert([
        'id' => 2,
        'category' => 'general2',
        'name_en' => 'General 2',
        'name_ar' => 'عام 2',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $department = Department::create([
        'clinic_id' => $clinic->id,
        'category_id' => 2,
        'description_en' => 'General',
        'description_ar' => 'عام',
        'location_ar' => 'جدة',
        'location_en' => 'Jeddah',
    ]);

    $doctor = Doctor::create([
        'serial_number' => 'MXTEST222222',
        'name_en' => 'Doctor 2',
        'name_ar' => 'طبيب 2',
        'specialization_en' => 'Dermatology',
        'specialization_ar' => 'جلدية',
        'birthdate' => '1988-01-01',
        'id_passport' => 'XYZ456',
        'photo' => 'doctor2.jpg',
        'working_hours' => 8,
    ]);

    $appointment = Appointment::create([
        'user_id' => $user->id,
        'doctor_id' => $doctor->id,
        'dep_id' => $department->id,
        'clinic_id' => $clinic->id,
        'date' => '2026-08-21',
        'time' => '2026-08-21 10:00:00',
        'appointment_fee' => 150,
        'doctor_cost' => 100,
        'status' => 'completed',
        'rating' => null,
    ]);

    $this->putJson('/api/appointments/' . $appointment->id . '/refresh-ratings', [])
        ->assertStatus(422)
        ->assertJsonFragment(['message' => 'The rating field is required.']);
});

it('updates department and clinic ratings from appointment ratings even without pivot data', function () {
    $clinic = Clinic::create([
        'email' => 'clinic3@example.com',
        'password' => bcrypt('secret'),
        'name_en' => 'Clinic 3',
        'name_ar' => 'عيادة 3',
        'owner_name' => 'Owner 3',
        'owner_idphoto' => 'owner3.jpg',
        'description_en' => 'Third clinic',
        'description_ar' => 'عيادة ثالثة',
        'location_ar' => 'الدمام',
        'location_en' => 'Dammam',
        'phone_number' => '0500000002',
        'is_approved' => true,
        'is_active' => true,
        'percentage' => 10,
    ]);

    DB::table('departments_categories')->insert([
        'id' => 3,
        'category' => 'general3',
        'name_en' => 'General 3',
        'name_ar' => 'عام 3',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $department = Department::create([
        'clinic_id' => $clinic->id,
        'category_id' => 3,
        'description_en' => 'General',
        'description_ar' => 'عام',
        'location_ar' => 'الدمام',
        'location_en' => 'Dammam',
    ]);

    $doctor = Doctor::create([
        'serial_number' => 'MXTEST333333',
        'name_en' => 'Doctor 3',
        'name_ar' => 'طبيب 3',
        'specialization_en' => 'Neurology',
        'specialization_ar' => 'عصبية',
        'birthdate' => '1985-01-01',
        'id_passport' => 'LMN789',
        'photo' => 'doctor3.jpg',
        'working_hours' => 8,
    ]);

    $user = User::factory()->create();

    $appointment = Appointment::create([
        'user_id' => $user->id,
        'doctor_id' => $doctor->id,
        'dep_id' => $department->id,
        'clinic_id' => $clinic->id,
        'date' => '2026-08-22',
        'time' => '2026-08-22 10:00:00',
        'appointment_fee' => 160,
        'doctor_cost' => 110,
        'status' => 'completed',
        'rating' => null,
    ]);

    $repository = app(AppointmentRepository::class);
    $repository->refreshRatingHierarchy($appointment, ['rating' => 4.5]);

    expect((float) $appointment->fresh()->rating)->toBe(4.5)
        ->and((float) $doctor->fresh()->rating)->toBe(4.5)
        ->and((float) $department->fresh()->rating)->toBe(4.5)
        ->and((float) $clinic->fresh()->rating)->toBe(4.5);
});
