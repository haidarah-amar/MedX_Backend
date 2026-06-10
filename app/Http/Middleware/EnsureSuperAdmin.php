<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();

        if (! $user || ! $user->isSuperAdmin()) {
            return response()->json([
                'message' => __('messages.forbidden'),
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
