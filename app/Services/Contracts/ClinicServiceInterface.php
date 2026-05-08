<?php

namespace App\Services\Contracts;

interface ClinicServiceInterface
{
    public function register(array $data);

    public function login(array $credentials);

    public function logout();

    public function getAuthenticatedClinic();

    public function update(int $id, array $data);

    public function activate(int $id);

    public function uploadImages(int $clinicId, array $images);
}