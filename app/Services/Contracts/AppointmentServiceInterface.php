<?php

namespace App\Services\Contracts;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface AppointmentServiceInterface
{
    public function getUserAppointments(User $user, ?string $status = null): LengthAwarePaginator;

    public function getForUser(User $user, Appointment $appointment): Appointment;

    public function createForUser(User $user, array $data): Appointment;

    public function cancelForUser(User $user, Appointment $appointment): Appointment;

    public function complete(Appointment $appointment, array $data): Appointment;
}
