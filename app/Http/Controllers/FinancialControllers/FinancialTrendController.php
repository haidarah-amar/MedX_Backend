<?php

namespace App\Http\Controllers\FinancialControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contracts\FinancialAnalyticsServiceInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class FinancialTrendController extends Controller
{
    public function __construct(
        private FinancialAnalyticsServiceInterface $service
    ) {}

    public function revenue(Request $request)
    {
        $clinic = JWTAuth::parseToken()->authenticate();

        return response()->json(
            $this->service->revenueTrend(
                $clinic->id,
                $request->from,
                $request->to
            )
        );
    }

    public function doctorCost(Request $request)
    {
        $clinic = JWTAuth::parseToken()->authenticate();

        return response()->json(
            $this->service->doctorCostTrend(
                $clinic->id,
                $request->from,
                $request->to
            )
        );
    }

    public function expenses(Request $request)
    {
        $clinic = JWTAuth::parseToken()->authenticate();

        return response()->json(
            $this->service->expensesTrend(
                $clinic->id,
                $request->from,
                $request->to
            )
        );
    }

    public function profit(Request $request)
    {
        $clinic = JWTAuth::parseToken()->authenticate();

        return response()->json(
            $this->service->profitTrend(
                $clinic->id,
                $request->from,
                $request->to
            )
        );
    }
}