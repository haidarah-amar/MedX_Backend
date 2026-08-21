<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\UploadedFile;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function register(array $data)
    {
        if (isset($data['id_passport']) && $data['id_passport'] instanceof UploadedFile) {
        $path = $data['id_passport']->store('users/passports', 'public');

        $data['id_passport'] = $path;
    }
        return $this->userRepository->create($data);
    }

    public function login(array $credentials)
    {
        return $this->userRepository->login($credentials);
    }

    public function logout()
    {
        return $this->userRepository->logout();
    }

    public function getAuthenticatedUser()
    {
        return $this->userRepository->getAuthenticatedUser();
    }

    public function updateProfile(int $id, array $data)
    {
        if (isset($data['id_passport']) && $data['id_passport'] instanceof UploadedFile) {
        $path = $data['id_passport']->store('users/passports', 'public');

        $data['id_passport'] = $path;
    }
        return $this->userRepository->update($id, $data);
    }
}
