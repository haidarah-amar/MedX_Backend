<?php

namespace App\Services\Contracts;

use App\Models\Doctor;
use Illuminate\Pagination\LengthAwarePaginator;

interface DoctorServiceInterface
{
    public function getById(int $doctorId): Doctor;

    public function create(array $data): Doctor;

    public function update(int $doctorId, array $data): Doctor;

    public function delete(int $doctorId): bool;

    public function findBySerial(string $serial): Doctor;

    public function contractDoctor(int $clinicId, array $data);

    public function getClinicDoctors(int $clinicId);

    public function getAllDoctors(): LengthAwarePaginator;
    public function uncontractDoctor(int $clinicId, array $data): bool;
}