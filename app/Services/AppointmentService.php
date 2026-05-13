<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\User;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Services\Contracts\AppointmentServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AppointmentService implements AppointmentServiceInterface
{
    public function __construct(
        protected AppointmentRepositoryInterface $appointmentRepository
    ) {}

    public function getUserAppointments(User $user, ?string $status = null): LengthAwarePaginator
    {
        return $this->appointmentRepository->paginateForUser($user->id, $status);
    }

    public function getForUser(User $user, Appointment $appointment): Appointment
    {
        $this->authorizeUser($user, $appointment);

        return $appointment->load(['doctor', 'department.clinic']);
    }

    public function createForUser(User $user, array $data): Appointment
    {
        $data['user_id'] = $user->id;
        $data['status'] = 'booked';
        $data['time'] = $data['date'] . ' ' . $data['time'] . ':00';

        $appointment = $this->appointmentRepository->create($data);

        return $appointment->load(['doctor', 'department.clinic']);
    }

    public function cancelForUser(User $user, Appointment $appointment): Appointment
    {
        $this->authorizeUser($user, $appointment);

        abort_if($appointment->status !== 'booked', 422, 'Only booked appointments can be canceled.');

        return $this->appointmentRepository->update($appointment, ['status' => 'canceled']);
    }

    public function complete(Appointment $appointment, array $data): Appointment
    {
        return $this->appointmentRepository->update(
            $appointment,
            array_merge($data, ['status' => 'completed'])
        );
    }

    private function authorizeUser(User $user, Appointment $appointment): void
    {
        abort_if($appointment->user_id !== $user->id, 403, 'Forbidden.');
    }
}
