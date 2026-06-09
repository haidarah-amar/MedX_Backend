<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\OperationalExpense;
use App\Repositories\Contracts\FinancialAnalyticsRepositoryInterface;

class FinancialAnalyticsRepository implements FinancialAnalyticsRepositoryInterface
{
    private function completedAppointments(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ) {
        return Appointment::query()
            ->where('clinic_id', $clinicId)
            ->where('status', 'completed')
            ->when(
                $from,
                fn ($q) => $q->whereDate('date', '>=', $from)
            )
            ->when(
                $to,
                fn ($q) => $q->whereDate('date', '<=', $to)
            )
            ->when(
                $departmentId,
                fn ($q) => $q->where('dep_id', $departmentId)
            );
    }

    public function revenueSum(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ): float {
        return (float) $this->completedAppointments(
            $clinicId,
            $from,
            $to,
            $departmentId
        )->sum('appointment_fee');
    }

    public function doctorCostSum(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ): float {
        return (float) $this->completedAppointments(
            $clinicId,
            $from,
            $to,
            $departmentId
        )->sum('doctor_cost');
    }

    public function expensesSum(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ): float {
        return (float) OperationalExpense::query()
            ->whereHas('department', function ($q) use ($clinicId) {
                $q->where('clinic_id', $clinicId);
            })
            ->when(
                $from,
                fn ($q) => $q->whereDate('expense_date', '>=', $from)
            )
            ->when(
                $to,
                fn ($q) => $q->whereDate('expense_date', '<=', $to)
            )
            ->when(
                $departmentId,
                fn ($q) => $q->where('department_id', $departmentId)
            )
            ->sum('amount');
    }

    public function patientInflow(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ) {
        return $this->completedAppointments(
            $clinicId,
            $from,
            $to,
            $departmentId
        )
        ->selectRaw("
            COUNT(*) total,
            SUM(CASE WHEN is_returning = 1 THEN 1 ELSE 0 END) returning_count,
            SUM(CASE WHEN is_returning = 0 THEN 1 ELSE 0 END) new_count
        ")
        ->first();
    }

    public function appointmentStatus(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ) {
        return Appointment::query()
            ->where('clinic_id', $clinicId)
            ->when(
                $from,
                fn ($q) => $q->whereDate('date', '>=', $from)
            )
            ->when(
                $to,
                fn ($q) => $q->whereDate('date', '<=', $to)
            )
            ->when(
                $departmentId,
                fn ($q) => $q->where('dep_id', $departmentId)
            )
            ->selectRaw("
                COUNT(*) total,
                SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) completed_count,
                SUM(CASE WHEN status='canceled' THEN 1 ELSE 0 END) canceled_count
            ")
            ->first();
    }

    public function departmentBreakdown(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    ) {
        $departments = Appointment::query()
            ->where('clinic_id', $clinicId)
            ->where('status', 'completed')
            ->when(
                $from,
                fn ($q) => $q->whereDate('date', '>=', $from)
            )
            ->when(
                $to,
                fn ($q) => $q->whereDate('date', '<=', $to)
            )
            ->selectRaw("
                dep_id,
                SUM(appointment_fee) as revenue,
                SUM(doctor_cost) as doctor_cost
            ")
            ->groupBy('dep_id')
            ->get();

        return $departments->map(function ($department) use ($clinicId, $from, $to) {

            $expenses = OperationalExpense::query()
                ->where('department_id', $department->dep_id)
                ->when(
                    $from,
                    fn ($q) => $q->whereDate('expense_date', '>=', $from)
                )
                ->when(
                    $to,
                    fn ($q) => $q->whereDate('expense_date', '<=', $to)
                )
                ->sum('amount');

            $departmentModel = Department::findOrFail($department->dep_id);

            return [
                'department_id' => $department->dep_id,
                'department_name' => $departmentModel?->category?->name_en ?? null,
                'revenue' => (float) $department->revenue,
                'doctor_cost' => (float) $department->doctor_cost,
                'expenses' => (float) $expenses,
                'net_profit' => (
                    (float) $department->revenue
                    - (float) $department->doctor_cost
                    - (float) $expenses
                ),
            ];
        });
    }

    public function revenueTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    ) {
        return Appointment::query()
            ->where('clinic_id', $clinicId)
            ->where('status', 'completed')
            ->when(
                $from,
                fn ($q) => $q->whereDate('date', '>=', $from)
            )
            ->when(
                $to,
                fn ($q) => $q->whereDate('date', '<=', $to)
            )
            ->selectRaw("
                DATE_FORMAT(date,'%Y-%m') as month,
                SUM(appointment_fee) as revenue
            ")
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function doctorCostTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    ) {
        return Appointment::query()
            ->where('clinic_id', $clinicId)
            ->where('status', 'completed')
            ->when(
                $from,
                fn ($q) => $q->whereDate('date', '>=', $from)
            )
            ->when(
                $to,
                fn ($q) => $q->whereDate('date', '<=', $to)
            )
            ->selectRaw("
                DATE_FORMAT(date,'%Y-%m') as month,
                SUM(doctor_cost) as doctor_cost
            ")
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function expensesTrend(
        int $clinicId,
        ?string $from = null,
        ?string $to = null
    ) {
        return OperationalExpense::query()
            ->whereHas('department', function ($q) use ($clinicId) {
                $q->where('clinic_id', $clinicId);
            })
            ->when(
                $from,
                fn ($q) => $q->whereDate('expense_date', '>=', $from)
            )
            ->when(
                $to,
                fn ($q) => $q->whereDate('expense_date', '<=', $to)
            )
            ->selectRaw("
                DATE_FORMAT(expense_date,'%Y-%m') as month,
                SUM(amount) as expenses
            ")
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}