<?php

namespace App\Repositories\Contracts;

use App\Models\Doctor;
use Illuminate\Pagination\LengthAwarePaginator;

interface DoctorRepositoryInterface
{
    public function allByClinic(int $clinicId): mixed;

    public function findById(int $doctorId): Doctor;

    public function create(array $data): Doctor;

    public function update(Doctor $doctor, array $data): Doctor;

    public function delete(Doctor $doctor): bool;

    public function findBySerial(string $serial): Doctor;
    public function contractDoctor(int $clinicId, int $doctorId, int $departmentId);

    public function uncontractDoctor(
    int $clinicId,
    int $doctorId,
    int $departmentId
    );
    public function getClinicDoctors(int $clinicId);

    public function getAllDoctors(): LengthAwarePaginator;

}
