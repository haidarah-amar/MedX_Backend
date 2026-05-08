<?php

namespace App\Services;

use App\Repositories\Contracts\ClinicRepositoryInterface;
use App\Services\Contracts\ClinicServiceInterface;

class ClinicService implements ClinicServiceInterface
{
    public function __construct(
        protected ClinicRepositoryInterface $clinicRepository
    ) {}

    public function register(array $data)
    {
        return $this->clinicRepository->create($data);
    }

    public function login(array $credentials)
    {
        return $this->clinicRepository->login($credentials);
    }

    public function logout()
    {
        return $this->clinicRepository->logout();
    }

    public function getAuthenticatedClinic()
    {
        return $this->clinicRepository->getAuthenticatedClinic();
    }

    public function update(int $id, array $data)
    {
        return $this->clinicRepository->update($id, $data);
    }

    public function activate(int $id)
    {
        return $this->clinicRepository->activateClinic($id);
    }

    public function uploadImages(int $clinicId, array $images)
    {
        return $this->clinicRepository->uploadImages($clinicId, $images);
    }
}