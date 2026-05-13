<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Services\Contracts\DoctorServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $data['department_id']
    );
}

    public function getClinicDoctors(int $clinicId)
{
    return $this->doctorRepository
        ->getClinicDoctors($clinicId);
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

