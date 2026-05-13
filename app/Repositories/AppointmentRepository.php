<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function paginateForUser(int $userId, ?string $status = null): LengthAwarePaginator
    {
        return Appointment::query()
            ->where('user_id', $userId)
            ->with(['doctor', 'department.clinic'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderByDesc('date')
            ->paginate(15);
    }

    public function create(array $data): Appointment
    {
        return Appointment::create($data);
    }

    public function update(Appointment $appointment, array $data): Appointment
    {
        $appointment->update($data);

        return $appointment;
    }
}
