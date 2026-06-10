<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\Contracts\ClinicServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class SuperAdminController extends Controller
{
    public function __construct(
        protected ClinicServiceInterface $clinicService
    ) {
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (
            !$user ||
            !$user->isSuperAdmin() ||
            !Hash::check($request->password, $user->password)
        ) {
            return response()->json([
                'error' => __('messages.unauthorized'),
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'token' => JWTAuth::fromUser($user),
            'user' => $user,
        ]);
    }

    public function clinics()
    {
        return response()->json([
            'clinics' => $this->clinicService->getAll(),
        ]);
    }

    public function approveClinic(int $clinicId)
    {
        $clinic = $this->clinicService->approve($clinicId);

        return response()->json([
            'message' => __('messages.clinic_approved'),
            'clinic' => $clinic,
        ]);
    }

    public function rejectClinic(Request $request, int $clinicId)
    {
        $data = $request->validate([
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $clinic = $this->clinicService->reject(
            $clinicId,
            $data['reason'] ?? null
        );

        return response()->json([
            'message' => __('messages.clinic_rejected'),
            'clinic' => $clinic,
        ]);
    }

    public function stopClinic(int $clinicId)
    {
        $clinic = $this->clinicService->stop($clinicId);

        return response()->json([
            'message' => __('messages.clinic_stopped'),
            'clinic' => $clinic,
        ]);
    }

    public function startClinic(int $clinicId)
    {
        $clinic = $this->clinicService->start($clinicId);

        return response()->json([
            'message' => __('messages.clinic_started'),
            'clinic' => $clinic,
        ]);
    }
}
