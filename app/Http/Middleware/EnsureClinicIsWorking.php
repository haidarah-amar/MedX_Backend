<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClinicIsWorking
{
    public function handle(Request $request, Closure $next): Response
    {
        $clinic = auth('clinic-api')->user();

        if (! $clinic || ! $clinic->isWorking()) {
            return response()->json([
                'message' => __('messages.clinic_not_working'),
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
