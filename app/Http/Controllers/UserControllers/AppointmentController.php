<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Services\Contracts\AppointmentServiceInterface;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(
        protected AppointmentServiceInterface $appointmentService
    ) {}

    public function index(Request $request)
    {
        return response()->json(
            $this->appointmentService->getUserAppointments($request->user(), $request->status)
        );
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
            'doctor_notes' => 'nullable|string',
        ]);

        $appointment = $this->appointmentService->complete($appointment, $data);

        return response()->json($appointment);
    }
}
