<?php

namespace App\Services\Contracts;

interface ClinicServiceInterface
{
    public function register(array $data);

    public function login(array $credentials);

    public function logout();

    public function getAuthenticatedClinic();

    public function getAll();

    public function update(int $id, array $data);

    public function activate(int $id);

    public function approve(int $id);

    public function reject(int $id, ?string $reason = null);

    public function stop(int $id);

    public function start(int $id);

    public function uploadImages(int $clinicId, array $images);
}
