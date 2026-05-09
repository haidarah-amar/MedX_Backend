<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function register(array $data)
    {
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
        return $this->userRepository->update($id, $data);
    }
}
