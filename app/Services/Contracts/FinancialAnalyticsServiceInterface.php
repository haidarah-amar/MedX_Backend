<?php

namespace App\Services\Contracts;

interface FinancialAnalyticsServiceInterface
{
    public function summary(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    );

    public function patientInflow(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    );

    public function appointmentStatus(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    );

    public function departmentBreakdown(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    );

    public function revenueTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    );

    public function doctorCostTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    );

    public function expensesTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    );

    public function profitTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    );
}