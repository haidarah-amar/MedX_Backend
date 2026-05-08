<?php

namespace App\Repositories\Contracts;

interface DepartmentRepositoryInterface
{
    public function findById(int $id);

    public function all();

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function findByIdForClinic(int $id, int $clinicId);

    public function allForClinic(int $clinicId);

    public function createForClinic(array $data, int $clinicId);

    public function updateForClinic(int $id, array $data, int $clinicId);

    public function deleteForClinic(int $id, int $clinicId);
}
