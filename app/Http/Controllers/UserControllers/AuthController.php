<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\Contracts\UserServiceInterface;

class AuthController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userService
    ) {
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userService->register($request->validated());

        $result = $this->userService->login($request->only('email', 'password'));

        return response()->json([
            'message' => 'تم تسجيل المستخدم بنجاح',
            'user' => $result['user'],
            'token' => $result['token'],
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->userService->login($request->only('email', 'password'));

        if ($result === null) {
            return response()->json([
                'error' => 'بيانات غير صحيحة',
            ], 401);
        }

        return response()->json($result);
    }

    public function logout()
    {
        $logout = $this->userService->logout();

        if (!$logout) {
            return response()->json([
                'message' => 'Token not found',
            ], 400);
        }

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح',
        ]);
    }

    public function profile()
    {
        return response()->json(
            $this->userService->getAuthenticatedUser()
        );
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth('api')->user();

        $updatedUser = $this->userService->updateProfile($user->id, $request->validated());

        return response()->json([
            'message' => 'تم تحديث الملف الشخصي بنجاح',
            'user' => $updatedUser,
        ]);
    }
}
