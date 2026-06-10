<?php

namespace App\Services;

use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Services\Contracts\AppointmentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentService implements AppointmentServiceInterface
{
    public function __construct(
        protected AppointmentRepositoryInterface $appointmentRepository
    ) {
    }

    public function getUserAppointments(User $user, ?string $status = null)
    {
        return $this->appointmentRepository->paginateForUser($user->id, $status);
    }

    public function getForUser(User $user, Appointment $appointment)
    {
        $this->authorizeUser($user, $appointment);

        return $appointment->load(['doctor', 'department.clinic']);
    }

    public function createForUser(User $user, array $data)
    {

        $clinic_id = Department::findOrFail($data['dep_id'])->clinic_id;
        $doctor_hourly_rate = $hourlyRate = DB::table('departments_doctors')
            ->where('doctor_id', $data['doctor_id'])
            ->where('clinic_id', $clinic_id)
            ->value('hourly_rate');
        $clinic_percentage = Clinic::findOrFail($clinic_id)->percentage;

        $fee = $doctor_hourly_rate + ($doctor_hourly_rate * $clinic_percentage / 100);

        $is_returning = DB::table('appointments')
            ->where('user_id', $user->id)
            ->where('clinic_id', $clinic_id)
            ->where('status', 'completed')
            ->exists();

        $data['is_returning'] = $is_returning;
        $data['doctor_cost'] = $doctor_hourly_rate;
        $data['user_id'] = $user->id;
        $data['clinic_id'] = $clinic_id;
        $data['status'] = 'booked';
        $data['time'] = $data['date'] . ' ' . $data['time'] . ':00';
        $data['appointment_fee'] = $fee;

        $appointment = $this->appointmentRepository->create($data);

        return $appointment->load(['doctor', 'department.clinic']);
    }

    public function cancelForUser(User $user, Appointment $appointment)
    {
        $this->authorizeUser($user, $appointment);

        abort_if($appointment->status !== 'booked', 422, 'Only booked appointments can be canceled.');

        return $this->appointmentRepository->cancel($appointment, ['status' => 'cancelled']);
    }

    public function complete(Appointment $appointment, array $data)
    {
        return $this->appointmentRepository->complete($appointment, ['status' => 'completed']);

    }

    private function authorizeUser(User $user, Appointment $appointment): void
    {
        abort_if($appointment->user_id !== $user->id, 403, 'Forbidden.');
    }

    public function update(Appointment $appointment, array $data)
    {
        return $this->appointmentRepository
            ->update($appointment, $data);
    }
}
