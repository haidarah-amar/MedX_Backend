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
        return Appointment::withoutGlobalScopes()
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
        return (float) $this->completedAppointments($clinicId, $from, $to, $departmentId)
            ->sum('appointment_fee');
    }

    public function doctorCostSum(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ): float {
        return (float) $this->completedAppointments($clinicId, $from, $to, $departmentId)
            ->sum('doctor_cost');
    }

    public function expensesSum(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ): float {
        return (float) OperationalExpense::withoutGlobalScopes()
            ->whereHas('department', function ($q) use ($clinicId) {
                $q->withoutGlobalScopes()->where('clinic_id', $clinicId);
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
        // الآن ستعمل الـ selectRaw بنجاح ساحق لأنها تُبنى فوق الـ Query Builder
        return $this->completedAppointments($clinicId, $from, $to, $departmentId)
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN is_returning = 1 THEN 1 ELSE 0 END) as returning_count,
                SUM(CASE WHEN is_returning = 0 THEN 1 ELSE 0 END) as new_count
            ")
            ->first(); // نستخدم first() لأننا نريد صفاً واحداً مجمعاً وليس كولكشن
    }

    public function appointmentStatus(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ) {
        return Appointment::withoutGlobalScopes()
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
                COUNT(*) as total,
                SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN status='canceled' THEN 1 ELSE 0 END) as canceled_count
            ")
            ->first(); // نستخدم first() هنا أيضاً لأنها تعيد إحصائية شاملة لصف واحد
    }

    public function departmentBreakdown(
        int $clinicId,
        ?string $from = null,
        ?string $to = null,
        ?int $departmentId = null
    ) {
        $departments = Appointment::withoutGlobalScopes()
            ->join('departments', 'appointments.dep_id', '=', 'departments.id')
            ->join('departments_categories', 'departments.category_id', '=', 'departments_categories.id')
            ->where('appointments.clinic_id', $clinicId)
            ->where('appointments.status', 'completed')
            ->when(
                $from,
                fn ($q) => $q->whereDate('appointments.date', '>=', $from)
            )
            ->when(
                $to,
                fn ($q) => $q->whereDate('appointments.date', '<=', $to)
            )
            ->when(
                $departmentId,
                fn ($q) => $q->where('appointments.dep_id', $departmentId)
            )
            ->selectRaw("
                appointments.dep_id,
                departments_categories.name_en as cat_name_en,
                SUM(appointments.appointment_fee) as revenue,
                SUM(appointments.doctor_cost) as doctor_cost
            ")
            ->groupBy('appointments.dep_id', 'departments_categories.name_en')
            ->get();

        return $departments->map(function ($department) use ($clinicId, $from, $to) {

            $expenses = OperationalExpense::withoutGlobalScopes()
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

            return [
                'department_id'   => $department->dep_id,
                'department_name' => $department->cat_name_en,
                'revenue'         => (float) $department->revenue,
                'doctor_cost'     => (float) $department->doctor_cost,
                'expenses'        => (float) $expenses,
                'net_profit'      => (
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
        ?string $to = null,
        ?int $departmentId = null
    ) {
        return Appointment::withoutGlobalScopes()
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
        ?string $to = null,
        ?int $departmentId = null
    ) {
        return Appointment::withoutGlobalScopes()
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
        ?string $to = null,
        ?int $departmentId = null
    ) {
        return OperationalExpense::withoutGlobalScopes()
            ->whereHas('department', function ($q) use ($clinicId) {
                $q->withoutGlobalScopes()->where('clinic_id', $clinicId);
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
            ->selectRaw("
                DATE_FORMAT(expense_date,'%Y-%m') as month,
                SUM(amount) as expenses
            ")
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}