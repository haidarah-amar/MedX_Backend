<?php

namespace App\Services;

use App\Models\Appointment;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Services\Contracts\DepartmentServiceInterface;
use Carbon\Carbon;

class DepartmentService implements DepartmentServiceInterface
{
    public function __construct(
        protected DepartmentRepositoryInterface $departmentRepository
    ) {}

    public function getAll()
    {
        return $this->departmentRepository->all();
    }

    public function getById(int $id)
    {
        return $this->departmentRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->departmentRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->departmentRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->departmentRepository->delete($id);
    }

public function getAllForClinic(int $clinicId)
{
    $departments = $this->departmentRepository
        ->allForClinic($clinicId);

    return $departments->map(function ($department) {

        $todayAppointmentsCount = Appointment::whereDepId($department->id)
        ->whereDate('date',Carbon::today())
        ->count();

        $department->today_appointments_count = $todayAppointmentsCount;

        return $department;
    });
}

    public function getByIdForClinic(int $id)
    {
        return $this->departmentRepository->findByIdForClinic($id);
    }

    public function createForClinic(array $data)
    {
        $clinic = auth('clinic-api')->user();

        if (!$clinic) {
            abort(403, 'Unauthorized');
        }

        return $this->departmentRepository->createForClinic($data, $clinic->id);
    }

    public function updateForClinic(int $id, array $data)
    {
        $clinic = auth('clinic-api')->user();

        if (!$clinic) {
            abort(403, 'Unauthorized');
        }

        return $this->departmentRepository->updateForClinic($id, $data, $clinic->id);
    }

    public function deleteForClinic(int $id)
    {
        $clinic = auth('clinic-api')->user();

        if (!$clinic) {
            abort(403, 'Unauthorized');
        }

        return $this->departmentRepository->deleteForClinic($id, $clinic->id);
    }

    public function getDepartmentStatistics(
    int $clinicId,
    int $departmentId
): array {
    return $this->departmentRepository
        ->getDepartmentStatistics(
            $clinicId,
            $departmentId
        );
}

public function getAllCategories()
{
    return $this->departmentRepository->getAllCategories();
}

}
