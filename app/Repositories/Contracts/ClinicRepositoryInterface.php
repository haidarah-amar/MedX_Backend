<?php

namespace App\Repositories\Contracts;

interface ClinicRepositoryInterface
{
    public function findById(int $id);

    public function findByEmail(string $email);

    public function all();

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function login(array $credentials);

    public function logout();

    public function getAuthenticatedClinic();

    public function activateClinic(int $id);

    public function uploadImages(int $clinicId, array $images);
}