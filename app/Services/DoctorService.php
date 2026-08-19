<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\Department;
use App\Models\Doctor;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Services\Contracts\DoctorServiceInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DoctorService implements DoctorServiceInterface
{
    public function __construct(
        protected DoctorRepositoryInterface $doctorRepository
    ) {}

    public function getById(int $doctorId): Doctor
    {
        return $this->doctorRepository->findById($doctorId);
    }

    public function create(array $data): Doctor
    {
        return $this->doctorRepository->create($data);
    }

    public function update(int $doctorId, array $data): Doctor
    {
        $doctor = $this->doctorRepository->findById($doctorId);
        return $this->doctorRepository->update($doctor, $data);
    }

    public function delete(int $doctorId): bool
    {
        $doctor = $this->doctorRepository->findById($doctorId);
        return $this->doctorRepository->delete($doctor);
    }

    public function findBySerial(string $serial): Doctor
    {
        return $this->doctorRepository->findBySerial($serial);
    }

    public function contractDoctor(int $clinicId, array $data)
{
    return $this->doctorRepository->contractDoctor(
        $clinicId,
        $data['doctor_id'],
        $data['department_id'],
        $data['hourly_rate']
    );
}

public function updateHourlyRate(int $clinicId, array $data)
{
    return $this->doctorRepository->updateHourlyRate(
        $clinicId,
        $data['doctor_id'],
        $data['department_id'],
        $data['hourly_rate']
    );
}

public function getClinicDoctors(int $clinicId): array
{
    $doctors = $this->doctorRepository
        ->getClinicDoctors($clinicId);

    $clinic = Clinic::findOrFail($clinicId);

    $currentTime = Carbon::now()->format('H:i:s');

    $totalDoctorsCount = DB::table('departments_doctors')
        ->where('clinic_id', $clinicId)
        ->distinct('doctor_id')
        ->count('doctor_id');

    $availableDoctorsCount = DB::table('departments_doctors')
        ->where('clinic_id', $clinicId)
        ->where('start_time', '<=', $currentTime)
        ->where('end_time', '>=', $currentTime)
        ->distinct('doctor_id')
        ->count('doctor_id');

    $doctors->getCollection()->transform(
        function ($doctor) use ($clinic) {

            $doctorHourlyRate = $doctor->departments
                ->first()
                ->pivot
                ->hourly_rate;

            $fee = $doctorHourlyRate
                + (
                    $doctorHourlyRate
                    * $clinic->percentage
                    / 100
                );

            $doctor->fee = $fee;

            return $doctor;
        }
    );

    return [
        'doctors' => $doctors,
        'statistics' => [
            'total_doctors_count' => $totalDoctorsCount,
            'available_doctors_count' => $availableDoctorsCount,
        ],
    ];
}

    public function getDoctorsByDepartment(int $departmentId)
{
    $doctors = $this->doctorRepository
        ->getDoctorsByDepartment($departmentId);

    $department = Department::with('clinic')
        ->findOrFail($departmentId);

    $clinic = $department->clinic;

    $doctors->transform(function ($doctor) use ($clinic) {

        $doctorHourlyRate = $doctor->departments
            ->first()
            ->pivot
            ->hourly_rate;

        $fee = $doctorHourlyRate
            + (
                $doctorHourlyRate
                * $clinic->percentage
                / 100
            );

        $doctor->fee = round($fee, 2);

        return $doctor;
    });

    return $doctors;
}

    public function getAllDoctors(): LengthAwarePaginator
    {
        return $this->doctorRepository->getAllDoctors();
    }

    public function uncontractDoctor(int $clinicId, array $data) : bool
{
    return $this->doctorRepository->uncontractDoctor(
        $clinicId,
        $data['doctor_id'],
        $data['department_id']
    );
}
}

