<?php

namespace App\Repositories;

use App\Models\OperationalExpense;
use App\Repositories\Contracts\OperationalExpenseRepositoryInterface;

class OperationalExpenseRepository
    implements OperationalExpenseRepositoryInterface
{
    public function getAll(int $clinicId)
    {
        return OperationalExpense::with('department')
            ->where('clinic_id', $clinicId)
            ->latest()
            ->paginate(20);
    }

    public function find(
        int $clinicId,
        int $id
    ): OperationalExpense
    {
        return OperationalExpense::whereClinicID(
            $clinicId
        )->findOrFail($id);
    }

    public function create(
        int $clinicId,
        array $data
    ): OperationalExpense
    {
        $data['clinic_id'] = $clinicId;

        return OperationalExpense::create($data);
    }

    public function update(
        int $clinicId,
        OperationalExpense $expense,
        array $data
    ): OperationalExpense
    {
        if ($expense->clinic_id !== $clinicId) {
            abort(403);
        }

        $expense->update($data);

        return $expense->fresh();
    }

    public function delete(
        int $clinicId,
        OperationalExpense $expense
    ): bool
    {
        if ($expense->clinic_id !== $clinicId) {
            abort(403);
        }

        return $expense->delete($expense?->id);
    }
}