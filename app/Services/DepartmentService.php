<?php

namespace App\Services;

use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Services\Contracts\DepartmentServiceInterface;

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

    public function getAllForClinic()
    {
        $clinic = auth('clinic-api')->user();

        if (!$clinic) {
            abort(403, 'Unauthorized');
        }

        return $this->departmentRepository->allForClinic($clinic->id);
    }

    public function getByIdForClinic(int $id)
    {
        $clinic = auth('clinic-api')->user();

        if (!$clinic) {
            abort(403, 'Unauthorized');
        }

        return $this->departmentRepository->findByIdForClinic($id, $clinic->id);
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
}
