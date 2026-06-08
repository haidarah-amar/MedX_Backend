<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryInterface;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function paginateForUser(int $userId, ?string $status = null)
    {
        return Appointment::query()
            ->where('user_id', $userId)
            ->with(['doctor', 'department.clinic'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderByDesc('date')
            ->paginate(15);
    }

    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function update(Appointment $appointment, array $data)
    {
        $appointment->update($data);

        return $appointment;
    }
    public function cancel(Appointment $appointment,array $data)
    {
        $appointment->update($data);

        return $appointment;
    }

    public function complete(Appointment $appointment,array $data)
    {
        $appointment->update($data);

        return $appointment;
    }

    public function updateDoctorNotes(
    int $appointmentId,
    string $doctorNotes
)
{
    $appointment = Appointment::findOrFail($appointmentId);

    $appointment->update([
        'doctor_notes' => $doctorNotes,
    ]);

    return $appointment;
}
}
