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
        if (isset($data['logo'])) {
            $data['logo'] = $data['logo']->store('clinics/logos', 'public');
        } else {
            $data['logo'] = 'defaults/clinic-logo.png';
        }

        if (isset($data['owner_idphoto'])) {
            $data['owner_idphoto'] = $data['owner_idphoto']->store('clinics/owners', 'public');
        }

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

    public function getAll()
    {
        return $this->clinicRepository->all();
    }

    public function update(int $id, array $data)
    {
        return $this->clinicRepository->update($id, $data);
    }

    public function activate(int $id)
    {
        return $this->clinicRepository->activateClinic($id);
    }

    public function approve(int $id)
    {
        return $this->clinicRepository->approve($id);
    }

    public function reject(int $id, ?string $reason = null)
    {
        return $this->clinicRepository->reject($id, $reason);
    }

    public function stop(int $id)
    {
        return $this->clinicRepository->stop($id);
    }

    public function start(int $id)
    {
        return $this->clinicRepository->start($id);
    }

    public function uploadImages(int $clinicId, array $images)
    {
        return $this->clinicRepository->uploadImages($clinicId, $images);
    }
}
