<?php

namespace App\Repositories\Contracts;

use App\Models\OperationalExpense;

interface OperationalExpenseRepositoryInterface
{
    public function getAll(int $clinicId);

    public function find(
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