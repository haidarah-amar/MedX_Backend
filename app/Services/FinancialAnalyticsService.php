<?php

namespace App\Services;

use App\Repositories\Contracts\FinancialAnalyticsRepositoryInterface;
use App\Services\Contracts\FinancialAnalyticsServiceInterface;

class FinancialAnalyticsService implements FinancialAnalyticsServiceInterface
{
    public function __construct(
        private FinancialAnalyticsRepositoryInterface $repository
    ) {}

    public function summary(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ) {
        $revenue = $this->repository->revenueSum(
            $clinicId,
            $from,
            $to,
            $departmentId
        );

        $doctorCost = $this->repository->doctorCostSum(
            $clinicId,
            $from,
            $to,
            $departmentId
        );

        $expenses = $this->repository->expensesSum(
            $clinicId,
            $from,
            $to,
            $departmentId
        );

        $operationalCost = $doctorCost + $expenses;

        $profit = $revenue - $operationalCost;

        return [
            'revenue' => $revenue,
            'doctor_cost' => $doctorCost,
            'expenses' => $expenses,
            'operational_cost' => $operationalCost,
            'net_profit' => $profit,
            'margin' => $revenue > 0
                ? round(($profit / $revenue) * 100, 2)
                : 0,
        ];
    }

    public function patientInflow(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ) {
        $stats = $this->repository->patientInflow(
            $clinicId,
            $from,
            $to,
            $departmentId
        );

        $total = max((int) $stats->total, 1);

        return [
            'new_patients' => (int) $stats->new_count,

            'returning_patients' => (int) $stats->returning_count,

            'new_percentage' =>
                round(($stats->new_count / $total) * 100, 2),

            'returning_percentage' =>
                round(($stats->returning_count / $total) * 100, 2),
        ];
    }

    public function appointmentStatus(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ) {
        $stats = $this->repository->appointmentStatus(
            $clinicId,
            $from,
            $to,
            $departmentId
        );

        $total = max((int) $stats->total, 1);

        return [
            'total' => (int) $stats->total,

            'completed' => (int) $stats->completed_count,

            'canceled' => (int) $stats->canceled_count,

            'completion_rate' =>
                round(($stats->completed_count / $total) * 100, 2),

            'cancellation_rate' =>
                round(($stats->canceled_count / $total) * 100, 2),
        ];
    }

    public function departmentBreakdown(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    ) {
        return $this->repository->departmentBreakdown(
            $clinicId,
            $from,
            $to
        );
    }

    public function revenueTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    ) {
        return $this->repository->revenueTrend(
            $clinicId,
            $from,
            $to
        );
    }

    public function doctorCostTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    ) {
        return $this->repository->doctorCostTrend(
            $clinicId,
            $from,
            $to
        );
    }

    public function expensesTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    ) {
        return $this->repository->expensesTrend(
            $clinicId,
            $from,
            $to
        );
    }

    public function profitTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    ) {
        $revenues = $this->repository->revenueTrend(
            $clinicId,
            $from,
            $to
        );

        $expenses = $this->repository->expensesTrend(
            $clinicId,
            $from,
            $to
        )->keyBy('month');

        $doctorCosts = $this->repository->doctorCostTrend(
            $clinicId,
            $from,
            $to
        )->keyBy('month');

        return $revenues->map(function ($row) use (
            $expenses,
            $doctorCosts
        ) {
            $doctorCost =
                $doctorCosts[$row->month]->doctor_cost ?? 0;

            $expense =
                $expenses[$row->month]->expenses ?? 0;

            return [
                'month' => $row->month,

                'profit' =>
                    $row->revenue
                    - $doctorCost
                    - $expense,
            ];
        });
    }
}