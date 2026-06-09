<?php

namespace App\Services\Contracts;

use App\Models\OperationalExpense;

interface OperationalExpenseServiceInterface
{
    public function getAll(int $clinicId);

    public function getById(
        int $clinicId,
        int $id
    ): OperationalExpense;

    public function create(
        int $clinicId,
        array $data
    ): OperationalExpense;

    public function update(
        int $clinicId,
        OperationalExpense $expense,
        array $data
    ): OperationalExpense;

    public function delete(
        int $clinicId,
        OperationalExpense $expense
    ): bool;
}