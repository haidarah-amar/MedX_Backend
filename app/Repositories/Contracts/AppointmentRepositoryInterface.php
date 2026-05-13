<?php

namespace App\Repositories\Contracts;

use App\Models\Appointment;

interface AppointmentRepositoryInterface
{
    public function paginateForUser(int $userId, ?string $status = null);

    public function create(array $data);

    public function update(Appointment $appointment, array $data);
}
