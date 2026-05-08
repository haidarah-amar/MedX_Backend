<?php

namespace App\Services\Contracts;

interface DepartmentServiceInterface
{
    public function getAll();

    public function getById(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getAllForClinic();

    public function getByIdForClinic(int $id);

    public function createForClinic(array $data);

    public function updateForClinic(int $id, array $data);

    public function deleteForClinic(int $id);
}
