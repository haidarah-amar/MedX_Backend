<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Department;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Doctor;
use App\Models\Clinic;
class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function paginateForUser(int $userId, ?string $status = null)
    {
        return Appointment::query()
            ->where('user_id', $userId)
            ->with(['doctor', 'department.clinic'])
            ->when($status, fn($query) => $query->where('status', $status))
            ->orderByDesc('date')
            ->paginate(15);
    }

    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function update(Appointment $appointment, array $data)
    {
        $appointment->update($data);

        return $appointment;
    }
    public function cancel(Appointment $appointment, array $data)
    {
        $appointment->update($data);

        return $appointment;
    }

    public function complete(Appointment $appointment, array $data)
    {
        $appointment->update($data);

        return $appointment;
    }

    public function paginateForClinic(int $clinicId, ?string $status = null)
    {
        return Appointment::query()
            ->where('clinic_id', $clinicId)
            ->with([
                'user',
                'doctor',
                'department.clinic',
            ])
            ->when(
                $status,
                fn($query) => $query->where(
                    'status',
                    $status
                )
            )
            ->orderByDesc('date')
            ->paginate(15);
    }
    public function getDepartmentWithClinic(int $departmentId)
    {
        return Department::with('clinic')->findOrFail($departmentId);
    }

    public function getDoctorsByDepartment(int $departmentId)
    {
        return DB::table('departments_doctors')
            ->join(
                'doctors',
                'doctors.id',
                '=',
                'departments_doctors.doctor_id'
            )
            ->where('departments_doctors.department_id', $departmentId)
            ->select(
                'doctors.id',
                'doctors.name_en',
                'doctors.name_ar',
                'departments_doctors.start_time',
                'departments_doctors.end_time'
            )
            ->get();
    }

    public function getBookedAppointments(
        int $departmentId,
        string $date
    ) {
        return Appointment::where('dep_id', $departmentId)
            ->where('date', $date)
            ->where('status', 'booked')
            ->select('doctor_id', 'time')
            ->get();
    }
    public function refreshRatingHierarchy(Appointment $appointment, array $data = [])
    {
        if (array_key_exists('rating', $data) && $data['rating'] !== null) {
            $appointment->update([
                'rating' => $this->formatRating((float) $data['rating']),
            ]);


        $doctorRating = Appointment::query()
            ->where('doctor_id', $appointment->doctor_id)
            ->where('status', 'completed')
            ->whereNotNull('rating')
            ->avg('rating');

        Doctor::whereKey($appointment->doctor_id)->update([
            'rating' => $this->formatRating($doctorRating),
        ]);

        $departmentRating = Appointment::query()
            ->where('dep_id', $appointment->dep_id)
            ->where('status', 'completed')
            ->whereNotNull('rating')
            ->avg('rating');

        Department::whereKey($appointment->dep_id)->update([
            'rating' => $this->formatRating($departmentRating),
        ]);

        $clinicRating = Department::query()
            ->where('clinic_id', $appointment->clinic_id)
            ->whereNotNull('rating')
            ->avg('rating');

        Clinic::whereKey($appointment->clinic_id)->update([
            'rating' => $this->formatRating($clinicRating),
        ]);

        return $appointment->fresh();
    }
    }


    private function formatRating(mixed $rating): ?float
    {
        return $rating === null ? null : round((float) $rating, 2);
    }


}
