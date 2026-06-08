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

    public function index(int $clinicId)
    {
        $departments = $this->departmentService->getAllForClinic($clinicId);

        return response()->json([
            'message' => __('messages.departments_fetched'),
            'data' => $departments
        ], 200);
    }

    public function store(StoreDepartmentRequest $request)
    {
        $department = $this->departmentService
            ->createForClinic($request->validated());

        return response()->json([
            'message' => __('messages.department_created'),
            'data' => $department
        ], 201);
    }

    public function show(int $id)
    {
        $department = $this->departmentService->getByIdForClinic($id);

        return response()->json([
            'message' => __('messages.department_fetched'),
            'data' => $department
        ], 200);
    }

    public function update(UpdateDepartmentRequest $request, int $id)
    {
        $department = $this->departmentService
            ->updateForClinic($id, $request->validated());

        return response()->json([
            'message' => __('messages.department_updated'),
            'data' => $department
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->departmentService->deleteForClinic($id);

        return response()->json([
            'message' => __('messages.department_deleted')
        ], 200);
    }
}
