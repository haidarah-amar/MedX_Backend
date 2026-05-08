<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function findById(int $id)
    {
        return Department::findOrFail($id);
    }

    public function all()
    {
        return Department::all();
    }

    public function create(array $data)
    {
        return Department::create($data);
    }

    public function update(int $id, array $data)
    {
        $department = $this->findById($id);

        $department->update($data);

        return $department;
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
        return Department::whereClinicId($clinicId)->get();
    }

    public function createForClinic(array $data, int $clinicId)
    {
        $data['clinic_id'] = $clinicId;
        return Department::create($data);
    }

    public function updateForClinic(int $id, array $data, int $clinicId)
    {
        $department = $this->findByIdForClinic($id, $clinicId);

        $department->update($data);

        return $department;
    }

    public function deleteForClinic(int $id, int $clinicId)
    {
        $department = $this->findByIdForClinic($id, $clinicId);

        return $department->delete();
    }
}
