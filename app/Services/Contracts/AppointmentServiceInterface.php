<?php

namespace App\Services\Contracts;

use App\Models\Appointment;
use App\Models\User;

interface AppointmentServiceInterface
{
    public function getUserAppointments(User $user, ?string $status = null);

    public function getForUser(User $user, Appointment $appointment);

    public function createForUser(User $user, array $data);

    public function cancelForUser(User $user, Appointment $appointment);

    public function complete(Appointment $appointment, array $data);
}
