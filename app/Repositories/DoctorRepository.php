<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function allByClinic(int $clinicId): mixed
    {
        return Doctor::whereClinicId($clinicId)->get();
    }

    public function findById(int $doctorId): Doctor
    {
        return Doctor::findOrFail($doctorId);
    }

    public function create(array $data): Doctor
    {
        return Doctor::create($data);
    }

    public function update(Doctor $doctor, array $data): Doctor
    {
        $doctor->update($data);
        return $doctor;
    }

    public function delete(Doctor $doctor): bool
    {
        return (bool) $doctor->delete($doctor->id);
    }

    public function findBySerial(string $serial): Doctor
    {
        return Doctor::whereSerialNumber($serial)->firstOrFail();
    }

    public function contractDoctor(
    int $clinicId,
    int $doctorId,
    int $departmentId
    ) {
    $doctor = Doctor::findOrFail($doctorId);

    $exists = $doctor->departments()
        ->where('department_id', $departmentId)
        ->exists();

    if ($exists) {
        return false;
    }

    $doctor->departments()->attach($departmentId, [
        'clinic_id' => $clinicId
    ]);

    return $doctor->load('departments');
}

    public function getClinicDoctors(int $clinicId)
{
    return Doctor::whereHas('departments', function ($query) use ($clinicId) {

        $query->where('departments_doctors.clinic_id', $clinicId);

    })
    ->with([
        'departments' => function ($query) use ($clinicId) {

            $query->wherePivot('clinic_id', $clinicId);

        }
    ])
    ->distinct()
    ->paginate(10);
}

    public function getAllDoctors(): LengthAwarePaginator
    {
        return Doctor::query()->paginate(10);
    }

    public function uncontractDoctor(
    int $clinicId,
    int $doctorId,
    int $departmentId
) {
    $doctor = Doctor::findOrFail($doctorId);

    $exists = $doctor->departments()
        ->where('department_id', $departmentId)
        ->wherePivot('clinic_id', $clinicId)
        ->exists();

    if (!$exists) {
        return false;
    }

    $doctor->departments()->newPivotStatement()
        ->where('doctor_id', $doctorId)
        ->where('department_id', $departmentId)
        ->where('clinic_id', $clinicId)
        ->delete();

    return true;
}
}

