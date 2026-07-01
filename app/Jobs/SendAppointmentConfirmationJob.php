<?php

namespace App\Jobs;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\NotificationService;

class SendAppointmentConfirmationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public Appointment $appointment)
    {
    }

    public function handle(NotificationService $notificationService): void
    {
        $appointment = $this->appointment->fresh([
            'user',
            'doctor',
            'department.clinic',
        ]);

        if (! $appointment || $appointment->status !== 'booked') {
            return;
        }

        $notificationService->notifyUser(
            $appointment->user,
            'appointment_confirmed',
            $notificationService->appointmentTitle('appointment_confirmed'),
            'Your appointment has been booked successfully.',
            $this->appointmentData($appointment)
        );
    }

    private function appointmentData(Appointment $appointment): array
    {
        return [
            'appointment_id' => $appointment->id,
            'doctor_id' => $appointment->doctor_id,
            'clinic_id' => $appointment->clinic_id,
            'department_id' => $appointment->dep_id,
            'scheduled_at' => $appointment->time?->toDateTimeString(),
        ];
    }
}
