<?php

namespace App\Exports\Sheets;

use App\Services\Contracts\FinancialAnalyticsServiceInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProfitTrendSheet implements
    FromCollection,
    WithHeadings,
    WithTitle,
    ShouldAutoSize
{
    public function __construct(
        private int $clinicId,
        private ?string $from,
        private ?string $to
    ) {}

    public function collection()
    {
        return app(
            FinancialAnalyticsServiceInterface::class
        )->profitTrend(
            $this->clinicId,
            $this->from,
            $this->to
        );
    }

    public function headings(): array
    {
        return ['Month', 'Profit'];
    }

    public function title(): string
    {
        return 'Profit Trend';
    }
}