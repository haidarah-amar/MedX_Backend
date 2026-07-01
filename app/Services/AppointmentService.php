<?php

namespace App\Services;

use App\Jobs\SendAppointmentConfirmationJob;
use App\Jobs\SendAppointmentReminderJob;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\User;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Services\Contracts\AppointmentServiceInterface;
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

        $lastAppointment = Appointment::query()
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->latest('id')
            ->first();

        abort_if(
            $lastAppointment && $lastAppointment->status !== 'completed',
            422,
            'You cannot book another appointment until your last appointment is completed.'
        );

        abort_if(
            $lastAppointment
                && $lastAppointment->status === 'completed'
                && $lastAppointment->updated_at->gt(now()->subDay()),
            422,
            'You must wait 24 hours after your last completed appointment before booking another appointment.'
        );

        $hasAppointmentInDepartment = Appointment::query()
            ->where('user_id', $user->id)
            ->where('dep_id', $data['dep_id'])
            ->exists();

        abort_if(
            $hasAppointmentInDepartment,
            422,
            'You cannot book another appointment in the same department.'
        );

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

        $this->dispatchAppointmentJobs($appointment);

        return $appointment->load(['doctor', 'department.clinic']);
    }

    public function cancelForUser(User $user, Appointment $appointment)
    {
        $this->authorizeUser($user, $appointment);

        abort_if($appointment->status !== 'booked', 422, 'Only booked appointments can be canceled.');

        $appointment = $this->appointmentRepository->cancel($appointment, ['status' => 'canceled']);

        $this->notifyAppointmentUser($appointment, 'appointment_canceled', 'Your appointment has been canceled.');

        return $appointment;
    }

    public function complete(Appointment $appointment, array $data)
    {
        $appointment = $this->appointmentRepository->complete($appointment, array_merge($data, [
            'status' => 'completed',
        ]));

        $this->notifyAppointmentUser($appointment, 'appointment_completed', 'Your appointment has been completed.');

        return $appointment;

    }

    private function authorizeUser(User $user, Appointment $appointment): void
    {
        abort_if($appointment->user_id !== $user->id, 403, 'Forbidden.');
    }

    public function update(Appointment $appointment, array $data)
    {
        $appointment = $this->appointmentRepository
            ->update($appointment, $data);

        $this->notifyAppointmentUser($appointment, 'appointment_updated', 'Your appointment details have been updated.');

        return $appointment;
    }

    private function dispatchAppointmentJobs(Appointment $appointment): void
    {
        SendAppointmentConfirmationJob::dispatch($appointment)->afterCommit();

        $reminderAt = $appointment->time?->copy()->subHours(2);

        if (! $reminderAt) {
            return;
        }

        SendAppointmentReminderJob::dispatch($appointment)
            ->delay($reminderAt->isFuture() ? $reminderAt : now())
            ->afterCommit();
    }

    private function notifyAppointmentUser(Appointment $appointment, string $type, string $body): void
    {
        $appointment->loadMissing('user');

        if (! $appointment->user) {
            return;
        }

        $notificationService = app(NotificationService::class);

        $notificationService->notifyUser(
            $appointment->user,
            $type,
            $notificationService->appointmentTitle($type),
            $body,
            [
                'appointment_id' => $appointment->id,
                'doctor_id' => $appointment->doctor_id,
                'clinic_id' => $appointment->clinic_id,
                'department_id' => $appointment->dep_id,
                'scheduled_at' => $appointment->time?->toDateTimeString(),
            ]
        );
    }
}
