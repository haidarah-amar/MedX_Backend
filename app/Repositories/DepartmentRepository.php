<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function findById(int $id)
    {
        return Department::findOrFail($id)->except(['created_at' , 'updated_at']);
    }

    public function all()
    {
        return Department::all()->except(['created_at' , 'updated_at']);
    }

    public function create(array $data)
    {
        return Department::create($data)->except(['created_at' , 'updated_at']);
    }

    public function update(int $id, array $data)
    {
        $department = $this->findById($id);

        $department->update($data);

        return $department->except(['created_at' , 'updated_at']);
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }

    public function findByIdForClinic(int $id, int $clinicId)
    {
        return Department::findOrFail($id)
                        ->where('clinic_id', $clinicId)
                        ->firstOrFail();
    }

    public function allForClinic(int $clinicId)
    {
        return Department::whereClinicId($clinicId)->get()->except(['created_at' , 'updated_at']);
    }

    public function createForClinic(array $data, int $clinicId)
    {
        $data['clinic_id'] = $clinicId;
        return Department::create($data)->except(['created_at' , 'updated_at']);
    }

    public function updateForClinic(int $id, array $data, int $clinicId)
    {
        $department = $this->findByIdForClinic($id, $clinicId);

        $department->update($data);

        return $department->except(['created_at' , 'updated_at']);
    }

    public function deleteForClinic(int $id, int $clinicId)
    {
        $department = $this->findByIdForClinic($id, $clinicId);

        return $department->delete();
    }

    public function getDepartmentStatistics(int $clinicId,int $departmentId): array {
    $now = Carbon::now()->setTimezone('Asia/Damascus');
    $currentTime = $now->format('H:i:s');

    $totalDoctorsCount = DB::table('departments_doctors')
        ->where('clinic_id', $clinicId)
        ->where('department_id', $departmentId)
        ->distinct()
        ->count('doctor_id');

        $capacity = DB::table('departments_doctors')
        ->where('clinic_id', $clinicId)
        ->where('department_id', $departmentId)
        ->selectRaw(
            '
            COALESCE(
                SUM(
                    TIMESTAMPDIFF(
                        MINUTE,
                        start_time,
                        end_time
                    ) / 60
                ),
                0
            ) AS capacity
            '
        )
        ->value('capacity');

    $availableDoctorsCount = DB::table('departments_doctors')
        ->where('clinic_id', $clinicId)
        ->where('department_id', $departmentId)
        ->where('start_time', '<=', $currentTime)
        ->where('end_time', '>', $currentTime)
        ->distinct()
        ->count('doctor_id');


    $currentHour = $now->copy()
        ->startOfHour();

    $currentPeopleCount = Appointment::query()
        ->where('dep_id', $departmentId)
        ->where('date', $currentHour->toDateString())
        ->count();

    return [
        'department_id' => $departmentId,

        'capacity' => (int) $capacity,

        'total_doctors_count' => $totalDoctorsCount,

        'available_doctors_count' => $availableDoctorsCount,

        'current_people_count' => $currentPeopleCount,
    ];
}
}
