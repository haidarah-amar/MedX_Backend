<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Requests\AppointmentRequest;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()
            ->appointments()
            ->with(['doctor', 'department.clinic']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->orderByDesc('date')->paginate(15));
    }

    public function show(Appointment $appointment)
    {
        $this->authorizeUser($appointment);
        $appointment->load(['doctor', 'department.clinic']);
        return response()->json($appointment);
    }

    public function store(AppointmentRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;
        $data['status']  = 'booked';
        $data['time']    = $data['date'] . ' ' . $data['time'] . ':00';

        $appointment = Appointment::create($data);
        $appointment->load(['doctor', 'department.clinic']);

        return response()->json($appointment, 201);
    }

    public function cancel(Appointment $appointment)
    {
        $this->authorizeUser($appointment);

        abort_if($appointment->status !== 'booked', 422, 'Only booked appointments can be canceled.');

        $appointment->update(['status' => 'canceled']);

        return response()->json($appointment);
    }

    // Doctor/Admin: add doctor notes and complete
    public function complete(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'doctor_notes' => 'nullable|string',
        ]);

        $appointment->update(array_merge($data, ['status' => 'completed']));

        return response()->json($appointment);
    }

    private function authorizeUser(Appointment $appointment): void
    {
        abort_if($appointment->user_id !== request()->user()->id, 403, 'Forbidden.');
    }
}
