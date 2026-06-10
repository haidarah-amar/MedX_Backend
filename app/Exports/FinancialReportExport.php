<?php

namespace App\Exports;

use App\Exports\Sheets\SummarySheet;
use App\Exports\Sheets\RevenueTrendSheet;
use App\Exports\Sheets\DoctorCostTrendSheet;
use App\Exports\Sheets\ExpensesTrendSheet;
use App\Exports\Sheets\ProfitTrendSheet;
use App\Exports\Sheets\DepartmentBreakdownSheet;
use App\Exports\Sheets\PatientInflowSheet;
use App\Exports\Sheets\AppointmentStatusSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FinancialReportExport implements WithMultipleSheets
{
    public function __construct(
        private int $clinicId,
        private ?string $from,
        private ?string $to,
        private ?int $departmentId
    ) {}

    public function sheets(): array
    {
        return [
            new SummarySheet(
                $this->clinicId,
                $this->from,
                $this->to,
                $this->departmentId
            ),

            new DepartmentBreakdownSheet(
                $this->clinicId,
                $this->from,
                $this->to,
               ),

            new RevenueTrendSheet(
                $this->clinicId,
                $this->from,
                $this->to,
                ),

            new DoctorCostTrendSheet(
                $this->clinicId,
                $this->from,
                $this->to,
               ),

            new ExpensesTrendSheet(
                $this->clinicId,
                $this->from,
                $this->to,
                ),

            new ProfitTrendSheet(
                $this->clinicId,
                $this->from,
                $this->to,
                ),

            new PatientInflowSheet(
                $this->clinicId,
                $this->from,
                $this->to,
                $this->departmentId
            ),

            new AppointmentStatusSheet(
                $this->clinicId,
                $this->from,
                $this->to,
                $this->departmentId
            ),
        ];
    }
}