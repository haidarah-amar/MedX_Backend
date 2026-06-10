<?php

namespace App\Exports\Sheets;

use App\Services\Contracts\FinancialAnalyticsServiceInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SummarySheet implements
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
        ->summary($this->clinicId, $this->from, $this->to, $this->departmentId);

    return collect([
        [
            $data['revenue'] ?? 0,
            $data['doctor_cost'] ?? 0,
            $data['expenses'] ?? 0,
            $data['operational_cost'] ?? 0,
            $data['net_profit'] ?? 0,
            ($data['margin'] ?? 0) . '%',
        ]
    ]);
}

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }

    public function title(): string
    {
        return 'Summary';
    }
}