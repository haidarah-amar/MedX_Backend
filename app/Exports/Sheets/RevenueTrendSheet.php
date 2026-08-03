<?php

namespace App\Exports\Sheets;

use App\Services\Contracts\FinancialAnalyticsServiceInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class RevenueTrendSheet implements
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
        return app(
            FinancialAnalyticsServiceInterface::class
        )->revenueTrend(
            $this->clinicId,
            $this->from,
            $this->to,
            $this->departmentId
        );
    }

    public function headings(): array
    {
        return ['Month', 'Revenue'];
    }

    public function title(): string
    {
        return 'Revenue Trend';
    }
}