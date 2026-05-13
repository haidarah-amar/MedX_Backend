<?php

namespace App\Http\Controllers\ClinicControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractDoctorRequest;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Services\Contracts\DoctorServiceInterface;

class DoctorController extends Controller
{
    public function __construct(
        protected DoctorServiceInterface $doctorService
    ) {}

    public function store(StoreDoctorRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        if ($request->hasFile('id_passport')) {
            $data['id_passport'] = $request->file('id_passport')->store('doctors', 'public');
        }

        $doctor = $this->doctorService->create($data);

        return response()->json([
            'message' => 'تم إنشاء الطبيب بنجاح',
            'data' => $doctor
        ], 201);
    }

    public function show(int $id)
    {
        $doctor = $this->doctorService->getById($id);

        return response()->json([
            'message' => 'تم جلب الطبيب بنجاح',
            'data' => $doctor
        ], 200);
    }

    public function update(UpdateDoctorRequest $request, int $id)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        $doctor = $this->doctorService->update($id, $data);

        return response()->json([
            'message' => 'تم تحديث الطبيب بنجاح',
            'data' => $doctor
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->doctorService->delete($id);

        return response()->json([
            'message' => 'تم حذف الطبيب بنجاح'
        ], 200);
    }

    public function findBySerial(string $serial)
    {
        $doctor = $this->doctorService->findBySerial($serial);

        return response()->json([
            'message' => 'تم جلب الطبيب بنجاح',
            'data' => $doctor
        ], 200);
    }

    public function index()
    {
        $doctors = $this->doctorService->getAllDoctors();

        return response()->json([
            'message' => 'تم جلب جميع الأطباء بنجاح',
            'data' => $doctors
        ], 200);
    }

    public function contract(ContractDoctorRequest $request)
{
    $clinic = auth('clinic-api')->user();

    $doctor = $this->doctorService->contractDoctor(
        $clinic->id,
        $request->validated()
    );

    if (!$doctor) {
        return response()->json([
            'message' => 'الطبيب مرتبط بالفعل مع هذا القسم'
        ], 409);
    }

    return response()->json([
        'message' => 'تم التعاقد مع الطبيب بنجاح',
        'data' => $doctor
    ], 201);
}
    public function clinicDoctors()
{
    $clinic = auth('clinic-api')->user();

    $doctors = $this->doctorService
        ->getClinicDoctors($clinic->id);

    return response()->json([
        'message' => 'تم جلب أطباء المركز بنجاح',
        'data' => $doctors
    ], 200);
}

public function uncontract(ContractDoctorRequest $request)
{
    $clinic = auth('clinic-api')->user();

    $result = $this->doctorService->uncontractDoctor(
        $clinic->id,
        $request->validated()
    );

    if (!$result) {
        return response()->json([
            'message' => 'الطبيب غير متعاقد مع هذا القسم'
        ], 404);
    }

    return response()->json([
        'message' => 'تم إلغاء التعاقد مع الطبيب بنجاح'
    ], 200);
}
}