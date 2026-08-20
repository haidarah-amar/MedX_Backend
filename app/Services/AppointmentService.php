<?php

namespace App\Services;

use App\Http\Requests\UpdateAppointmentRequest;
use App\Jobs\SendAppointmentReminderJob;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\User;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Services\Contracts\AppointmentServiceInterface;
use Illuminate\Support\Carbon;
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
        // $this->authorizeUser($user, $appointment);

        return $appointment->load(['doctor', 'department.clinic']);
    }

    public function createForUser(User $user, array $data)
    {
        $clinic_id = Department::findOrFail($data['dep_id'])->clinic_id;

        $lastAppointment = Appointment::query()
            ->where('user_id', $user->id)
            ->where('dep_id', $data['dep_id'])
            ->latest('created_at')
            ->latest('id')
            ->first();

        abort_if(
            $lastAppointment && $lastAppointment->status === 'booked',
            422,
            'You cannot book another appointment in this department until your last appointment is completed.'
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
            ->where('status', 'booked')
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

        $clinic = Clinic::findOrFail($clinic_id);

        if (!$clinic || $clinic->approval_status != "approved") {
            abort(422, 'The clinic is not available for appointments.');
        }

        $appointment = $this->appointmentRepository->create($data);

        $this->notifyAppointmentUser(
            $appointment,
            'appointment_confirmed',
            'Your appointment has been booked successfully.'
        );

        $this->dispatchAppointmentReminderJob($appointment);

        return $appointment->load(['doctor', 'department.clinic']);
    }

    public function createForClinic(Clinic $clinic, User $user, array $data)
    {
        $department = Department::findOrFail($data['dep_id']);

        abort_if(
            $department->clinic_id !== $clinic->id,
            403,
            'This department does not belong to the clinic.'
        );

        return $this->createForUser($user, $data);
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

    public function refreshRatingHierarchy(Appointment $appointment, array $data)
    {
        $appointment = $this->appointmentRepository
            ->refreshRatingHierarchy($appointment, $data);
        return $appointment;
    }

    private function dispatchAppointmentReminderJob(Appointment $appointment): void
    {
        $reminderAt = $appointment->time?->copy()->subHours(2);

        if (!$reminderAt) {
            return;
        }

        SendAppointmentReminderJob::dispatch($appointment)
            ->delay($reminderAt->isFuture() ? $reminderAt : now())
            ->afterCommit();
    }

    private function notifyAppointmentUser(Appointment $appointment, string $type, string $body): void
    {
        $appointment->loadMissing('user');

        if (!$appointment->user) {
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

    public function getClinicAppointments(int $clinicId, ?string $status = null)
    {
        return $this->appointmentRepository->paginateForClinic($clinicId, $status);
    }

    public function getAvailableAppointments(
        int $departmentId,
        string $date
    ): array {

        $department = $this->appointmentRepository
            ->getDepartmentWithClinic($departmentId);

        $doctors = $this->appointmentRepository
            ->getDoctorsByDepartment($departmentId);

        $bookedAppointments = $this->appointmentRepository
            ->getBookedAppointments($departmentId, $date);

        $clinicStart = Carbon::parse(
            $department->clinic->start_time
        );

        $clinicEnd = Carbon::parse(
            $department->clinic->end_time
        );

        $bookedByDoctor = $bookedAppointments
            ->groupBy('doctor_id');

        $result = [];

        foreach ($doctors as $doctor) {

            $doctorStart = Carbon::parse($doctor->start_time);
            $doctorEnd = Carbon::parse($doctor->end_time);


            $start = $doctorStart->greaterThan($clinicStart)
                ? $doctorStart
                : $clinicStart;

            $end = $doctorEnd->lessThan($clinicEnd)
                ? $doctorEnd
                : $clinicEnd;

            $allSlots = $this->generateTimeSlots(
                $start,
                $end
            );


            $bookedTimes = collect(
                $bookedByDoctor->get($doctor->id, [])
            )->map(function ($appointment) {

                $time = Carbon::parse($appointment->time);

                return $time->format('H:00');

            })->unique()->values()->toArray();


            $availableTimes = array_values(
                array_diff(
                    $allSlots,
                    $bookedTimes
                )
            );

            $result[] = [
                'doctor_id' => $doctor->id,
                'doctor_name_en' => $doctor->name_en,
                'doctor_name_ar' => $doctor->name_ar,

                'working_hours' => [
                    'start' => $start->format('H:i'),
                    'end' => $end->format('H:i'),
                ],

                'available_times' => $availableTimes,
            ];
        }

        return [
            'department_id' => $departmentId,
            'date' => $date,
            'doctors' => $result,
        ];
    }
    private function generateTimeSlots(
        Carbon $start,
        Carbon $end
    ): array {

        $slots = [];

        $current = $start->copy();

        while ($current < $end) {

            $slots[] = $current->format('H:i');

            $current->addHour();
        }

        return $slots;
    }
}
