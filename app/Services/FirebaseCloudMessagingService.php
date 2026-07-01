<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class FirebaseCloudMessagingService
{
    public function sendToToken(string $token, string $title, string $body, array $data = []): array
    {
        if (! config('services.firebase.enabled')) {
            Log::info('Firebase notification skipped because firebase is disabled.', [
                'token' => $token,
                'title' => $title,
            ]);

            return ['skipped' => true];
        }

        $projectId = $this->projectId();
        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $this->stringifyData($data),
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'sound' => 'default',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'default',
                        ],
                    ],
                ],
            ],
        ];

        $response = Http::withToken($this->accessToken())
            ->acceptJson()
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload);

        if ($response->failed()) {
            throw new RuntimeException($response->body());
        }

        return $response->json() ?? [];
    }

    private function accessToken(): string
    {
        return Cache::remember('firebase.access_token', now()->addMinutes(50), function () {
            $account = $this->serviceAccount();
            $now = time();

            $jwt = $this->base64UrlEncode(json_encode([
                'alg' => 'RS256',
                'typ' => 'JWT',
            ])) . '.' . $this->base64UrlEncode(json_encode([
                'iss' => $account['client_email'],
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ]));

            openssl_sign($jwt, $signature, $account['private_key'], 'sha256WithRSAEncryption');
            $assertion = $jwt . '.' . $this->base64UrlEncode($signature);

            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $assertion,
            ]);

            if ($response->failed()) {
                throw new RuntimeException('Unable to authenticate with Firebase: ' . $response->body());
            }

            return $response->json('access_token');
        });
    }

    private function serviceAccount(): array
    {
        $json = config('services.firebase.credentials_json');
        $path = config('services.firebase.credentials_path');

        if ($json) {
            $account = json_decode($json, true);
        } elseif ($path && file_exists($path)) {
            $account = json_decode(file_get_contents($path), true);
        } else {
            throw new RuntimeException('Firebase service account credentials are not configured.');
        }

        if (! is_array($account) || empty($account['client_email']) || empty($account['private_key'])) {
            throw new RuntimeException('Firebase service account credentials are invalid.');
        }

        return $account;
    }

    private function projectId(): string
    {
        $projectId = config('services.firebase.project_id')
            ?: ($this->serviceAccount()['project_id'] ?? null);

        if (! $projectId) {
            throw new RuntimeException('Firebase project id is not configured.');
        }

        return $projectId;
    }

    private function stringifyData(array $data): array
    {
        return collect($data)
            ->map(fn ($value) => is_scalar($value) || $value === null ? (string) $value : json_encode($value))
            ->all();
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
