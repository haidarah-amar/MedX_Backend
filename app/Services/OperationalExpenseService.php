<?php

namespace App\Services;

use App\Models\OperationalExpense;
use App\Repositories\Contracts\OperationalExpenseRepositoryInterface;
use App\Services\Contracts\OperationalExpenseServiceInterface;

class OperationalExpenseService
    implements OperationalExpenseServiceInterface
{
    public function __construct(
        private OperationalExpenseRepositoryInterface $repository
    ) {}

    public function getAll(int $clinicId)
    {
        return $this->repository->getAll($clinicId);
    }

    public function getById(
        int $clinicId,
        int $id
    ): OperationalExpense
    {
        return $this->repository->find(
            $clinicId,
            $id
        );
    }

    public function create(
        int $clinicId,
        array $data
    ): OperationalExpense
    {
        return $this->repository->create(
            $clinicId,
            $data
        );
    }

    public function update(
        int $clinicId,
        OperationalExpense $expense,
        array $data
    ): OperationalExpense
    {
        return $this->repository->update(
            $clinicId,
            $expense,
            $data
        );
    }

    public function delete(
        int $clinicId,
        OperationalExpense $expense
    ): bool
    {
        return $this->repository->delete(
            $clinicId,
            $expense
        );
    }
}