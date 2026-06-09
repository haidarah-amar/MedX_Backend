<?php

namespace App\Http\Controllers\FinancialControllers;

use App\Http\Controllers\Controller;
use App\Services\Contracts\FinancialAnalyticsServiceInterface;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class FinancialDashboardController extends Controller
{
    public function __construct(
        private FinancialAnalyticsServiceInterface $service
    ) {}

    public function summary(Request $request)
    {
        $clinic = JWTAuth::parseToken()->authenticate();

        return response()->json(
            $this->service->summary(
                $clinic->id,
                $request->from,
                $request->to,
                $request->department_id
            )
        );
    }

    public function patientInflow(Request $request)
    {
        $clinic = JWTAuth::parseToken()->authenticate();

        return response()->json(
            $this->service->patientInflow(
                $clinic->id,
                $request->from,
                $request->to,
                $request->department_id
            )
        );
    }

    public function appointmentStatus(Request $request)
    {
        $clinic = JWTAuth::parseToken()->authenticate();

        return response()->json(
            $this->service->appointmentStatus(
                $clinic->id,
                $request->from,
                $request->to,
                $request->department_id
            )
        );
    }

    public function departments(Request $request)
    {
        $clinic = JWTAuth::parseToken()->authenticate();

        return response()->json(
            $this->service->departmentBreakdown(
                $clinic->id,
                $request->from,
                $request->to
            )
        );
    }
}