<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;
use App\Services\Contracts\ClinicServiceInterface;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function __construct(
        protected ClinicServiceInterface $clinicService
    ) {}

    public function store(StoreClinicRequest $request)
    {
        $clinic = $this->clinicService
            ->register($request->validated());

        return response()->json([
            'message' => 'تم تسجيل العيادة بنجاح',
            'clinic' => $clinic
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->clinicService
            ->login($request->only('email', 'password'));

        if ($result === null) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        if ($result === false) {
            return response()->json([
                'error' => 'لم يتم تفعيل الحساب بعد'
            ], 403);
        }

        return response()->json($result);
    }

    public function logout()
    {
        $logout = $this->clinicService->logout();

        if (!$logout) {
            return response()->json([
                'message' => 'Token not found'
            ], 400);
        }

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح'
        ]);
    }

    public function show()
    {
        return response()->json(
            $this->clinicService
                ->getAuthenticatedClinic()
        );
    }

    public function update(UpdateClinicRequest $request)
    {
        $clinic = auth('clinic-api')->user();

        $updatedClinic = $this->clinicService
            ->update($clinic->id, $request->validated());

        return response()->json([
            'message' => 'تم تحديث بيانات العيادة بنجاح',
            'clinic' => $updatedClinic
        ]);
    }

    public function activate()
    {
        $clinic = auth('clinic-api')->user();

        $updatedClinic = $this->clinicService
            ->activate($clinic->id);

        return response()->json([
            'message' => 'تم تحديث حالة العيادة بنجاح',
            'is_active' => $updatedClinic->is_active
        ]);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $clinic = auth('clinic-api')->user();

        $images = $this->clinicService
            ->uploadImages(
                $clinic->id,
                $request->file('images')
            );

        return response()->json([
            'message' => 'تمت اضافة الصور بنجاح',
            'data' => $images
        ]);
    }
}