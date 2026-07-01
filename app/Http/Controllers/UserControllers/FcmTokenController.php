<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string', 'max:4096'],
            'device_type' => ['nullable', 'string', 'max:30'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $token = $request->user()->fcmTokens()->updateOrCreate(
            ['token' => $data['token']],
            [
                'device_type' => $data['device_type'] ?? null,
                'device_name' => $data['device_name'] ?? null,
                'is_active' => true,
                'last_used_at' => now(),
            ]
        );

        return response()->json([
            'message' => 'FCM token saved successfully.',
            'data' => $token,
        ], 201);
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $request->user()->fcmTokens()
            ->where('token', $data['token'])
            ->delete();

        return response()->json([
            'message' => 'FCM token deleted successfully.',
        ]);
    }
}
