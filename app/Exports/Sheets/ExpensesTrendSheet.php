<?php

namespace App\Exports\Sheets;

use App\Services\Contracts\FinancialAnalyticsServiceInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExpensesTrendSheet implements
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
        )->expensesTrend(
            $this->clinicId,
            $this->from,
            $this->to
        );
    }

    public function headings(): array
    {
        return ['Month', 'Expenses'];
    }

    public function title(): string
    {
        return 'Expenses Trend';
    }
}