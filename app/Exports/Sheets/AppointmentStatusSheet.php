<?php

namespace App\Exports\Sheets;

use App\Services\Contracts\FinancialAnalyticsServiceInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AppointmentStatusSheet implements
    FromCollection,
    WithHeadings,
    WithTitle,
    ShouldAutoSize
{
    public function __construct(
        private int $clinicId,
        private ?string $from,
        private ?string $to,
        private ?int $departmentId
    ) {}

    public function collection()
{
    $data = app(FinancialAnalyticsServiceInterface::class)
        ->appointmentStatus($this->clinicId, $this->from, $this->to, $this->departmentId);

    return collect([
        [
            $data['total'] ?? 0,
            $data['completed'] ?? 0,
            $data['canceled'] ?? 0,
            ($data['completion_rate'] ?? 0) . '%',
            ($data['cancellation_rate'] ?? 0) . '%',
        ]
    ]);
}

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }

    public function title(): string
    {
        return 'Appointment Status';
    }
}