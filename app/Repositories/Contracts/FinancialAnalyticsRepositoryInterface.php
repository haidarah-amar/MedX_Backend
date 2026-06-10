<?php

namespace App\Repositories\Contracts;

interface FinancialAnalyticsRepositoryInterface
{
    public function revenueSum(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ): float;

    public function doctorCostSum(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ): float;

    public function expensesSum(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ): float;

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
        ?string $to = null,
        ?int $departmentId = null
    );

    public function revenueTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    );

    public function doctorCostTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    );

    public function expensesTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    );
}