<?php

namespace App\Repositories\Contracts;

use App\Models\Appointment;
use Illuminate\Pagination\LengthAwarePaginator;

interface AppointmentRepositoryInterface
{
    public function paginateForUser(int $userId, ?string $status = null): LengthAwarePaginator;

    public function create(array $data): Appointment;

    public function update(Appointment $appointment, array $data): Appointment;
}
