<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Http\Requests\AvailableAppointmentsRequest;
use App\Models\Appointment;
use App\Services\Contracts\AppointmentServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Requests\UpdateDoctorNotesRequest;
use App\Models\Clinic;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AppointmentController extends Controller
{
    public function __construct(
        protected AppointmentServiceInterface $appointmentService
    ) {
    }

   public function index(Request $request)
{
    $payload = JWTAuth::parseToken()->getPayload();

    $accountType = $payload->get('account_type');

    if ($accountType === 'clinic') {
        $clinicId = (int) $payload->get('sub');

        return response()->json(
            $this->appointmentService->getClinicAppointments(
                $clinicId,
                $request->status
            )
        );
    }


        $user = JWTAuth::parseToken()->authenticate();

        return response()->json(
            $this->appointmentService->getUserAppointments(
                $user,
                $request->status
            )
        );
    

    // return response()->json([
    //     'message' => 'Invalid account type.'
    // ], 401);
}

    public function show(Request $request, Appointment $appointment)
    {
        return response()->json(
            $this->appointmentService->getForUser($request->user(), $appointment)
        );
    }

    public function store(AppointmentRequest $request)
    {
        $appointment = $this->appointmentService->createForUser(
            $request->user(),
            $request->validated()
        );

        return response()->json($appointment, 201);
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        $appointment = $this->appointmentService->cancelForUser($request->user(), $appointment);

        return response()->json($appointment);
    }

    // Doctor/Admin: add doctor notes and complete
    public function complete(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'doctor_notes' => 'required|string',
        ]);

        $payload = JWTAuth::parseToken()->getPayload();
        $accountType = $payload->get('account_type');

        response()->json(['data' => $accountType]);

    if ($accountType === 'clinic') {
        $clinicId = (int) $payload->get('sub');

        if ($appointment->clinic_id !== $clinicId) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $appointment = $this->appointmentService->complete($appointment, $data);

        return response()->json(['data' => $appointment , 200]);
    } else {
        return response()->json([
            'data' => 'account type is ' . $accountType,
            'message' => 'Forbidden.'], 403);
    }
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment = $this->appointmentService->update(
            $appointment,
            $request->validated()
        );

        return response()->json([
            'message' => 'تم تحديث بيانات الموعد بنجاح ',
            'data' => $appointment
        ]);
    }

    public function available( AvailableAppointmentsRequest $request, int $departmentId
    ) {
        $data = $this->appointmentService->getAvailableAppointments(
            $departmentId,
            $request->date('date')
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
