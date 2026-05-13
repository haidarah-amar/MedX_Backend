<?php

namespace App\Http\Controllers\ClinicControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Services\Contracts\DepartmentServiceInterface;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentServiceInterface $departmentService
    ) {}

    public function index()
    {
        $departments = $this->departmentService->getAllForClinic();

        return response()->json([
            'message' => 'تم جلب جميع الأقسام بنجاح',
            'data' => $departments
        ], 200);
    }

    public function store(StoreDepartmentRequest $request)
    {
        $department = $this->departmentService
            ->createForClinic($request->validated());

        return response()->json([
            'message' => 'تم إنشاء القسم بنجاح',
            'data' => $department
        ], 201);
    }

    public function show(int $id)
    {
        $department = $this->departmentService->getByIdForClinic($id);

        return response()->json([
            'message' => 'تم جلب القسم بنجاح',
            'data' => $department
        ], 200);
    }

    public function update(UpdateDepartmentRequest $request, int $id)
    {
        $department = $this->departmentService
            ->updateForClinic($id, $request->validated());

        return response()->json([
            'message' => 'تم تحديث القسم بنجاح',
            'data' => $department
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->departmentService->deleteForClinic($id);

        return response()->json([
            'message' => 'تم حذف القسم بنجاح'
        ], 200);
    }
}
