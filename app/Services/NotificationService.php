<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Throwable;

class NotificationService
{
    public function notifyUser(User $user, string $type, string $title, string $body, array $data = []): Notification
    {
        $notification = $user->notifications()->create([
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'data' => $data,
        ]);

        $this->sendPush($user, $notification);

        return $notification;
    }

    public function sendPush(User $user, Notification $notification): void
    {
        $tokens = $user->fcmTokens()
            ->where('is_active', true)
            ->get();

        if ($tokens->isEmpty()) {
            return;
        }

        $hasSuccess = false;
        $lastError = null;

        foreach ($tokens as $token) {
            try {
                app(FirebaseCloudMessagingService::class)->sendToToken(
                    $token->token,
                    $notification->title,
                    $notification->body,
                    array_merge($notification->data ?? [], [
                        'notification_id' => $notification->id,
                        'type' => $notification->type,
                    ])
                );

                $hasSuccess = true;
                $token->update(['last_used_at' => now()]);
            } catch (Throwable $exception) {
                $lastError = $exception->getMessage();

                if (str_contains($lastError, 'UNREGISTERED') || str_contains($lastError, 'INVALID_ARGUMENT')) {
                    $token->update(['is_active' => false]);
                }

                Log::warning('Firebase notification delivery failed.', [
                    'notification_id' => $notification->id,
                    'fcm_token_id' => $token->id,
                    'error' => $lastError,
                ]);
            }
        }

        $notification->update([
            'sent_at' => $hasSuccess ? now() : null,
            'send_error' => $hasSuccess ? null : $lastError,
        ]);
    }

    public function appointmentTitle(string $event): string
    {
        return match ($event) {
            'appointment_confirmed' => 'Appointment confirmed',
            'appointment_reminder' => 'Appointment reminder',
            'appointment_canceled' => 'Appointment canceled',
            'appointment_completed' => 'Appointment completed',
            'appointment_updated' => 'Appointment updated',
            default => 'Notification',
        };
    }
}
