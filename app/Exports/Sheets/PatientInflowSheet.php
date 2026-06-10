<?php

namespace App\Exports\Sheets;

use App\Services\Contracts\FinancialAnalyticsServiceInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PatientInflowSheet implements
    FromCollection,
    WithHeadings,
    WithTitle,
    ShouldAutoSize
{
    // إضافة المتغير الرابع لاستقبال الـ departmentId
    public function __construct(
        private int $clinicId,
        private ?string $from,
        private ?string $to,
        private ?int $departmentId
    ) {}

    public function collection()
{
    $data = app(FinancialAnalyticsServiceInterface::class)
        ->patientInflow($this->clinicId, $this->from, $this->to, $this->departmentId);

    return collect([
        [
            $data['new_patients'] ?? 0,
            $data['returning_patients'] ?? 0,
            ($data['new_percentage'] ?? 0) . '%',
            ($data['returning_percentage'] ?? 0) . '%',
        ]
    ]);
}

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }

    public function title(): string
    {
        return 'Patient Inflow';
    }
}