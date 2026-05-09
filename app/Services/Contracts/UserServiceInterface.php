<?php

namespace App\Services\Contracts;

interface UserServiceInterface
{
    public function register(array $data);

    public function login(array $credentials);

    public function logout();

    public function getAuthenticatedUser();

    public function updateProfile(int $id, array $data);
}
