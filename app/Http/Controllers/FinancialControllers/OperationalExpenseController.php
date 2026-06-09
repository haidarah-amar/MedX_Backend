<?php

namespace App\Http\Controllers\FinancialControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOperationalExpense;
use App\Http\Requests\UpdateOperationalExpense;
use App\Models\Department;
use App\Models\OperationalExpense;
use App\Services\Contracts\OperationalExpenseServiceInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class OperationalExpenseController extends Controller
{
    public function __construct(
        private OperationalExpenseServiceInterface $service
    ) {}

    public function index()
    {
        $clinic = JWTAuth::parseToken()->authenticate();

        return response()->json(
            $this->service->getAll($clinic->id)
        );
    }

    public function show(
        OperationalExpense $operationalExpense
    ) {
        $clinic = JWTAuth::parseToken()->authenticate();

        abort_unless(
            $operationalExpense->clinic_id === $clinic->id,
            403,
            'Unauthorized'
        );

        return response()->json(
            $operationalExpense
        );
    }

    public function store(
        StoreOperationalExpense $request
    ) {
        $clinic = JWTAuth::parseToken()->authenticate();

        if ($request->department_id) {

            $department = Department::findOrFail(
                $request->department_id
            );

            abort_unless(
                $department->clinic_id === $clinic->id,
                403,
                'Unauthorized department'
            );
        }

        $expense = $this->service->create(
            $clinic->id,
            $request->validated()
        );

        return response()->json(
            $expense,
            201
        );
    }

    public function update(
        UpdateOperationalExpense $request,
        OperationalExpense $operationalExpense
    ) {
        $clinic = JWTAuth::parseToken()->authenticate();

        abort_unless(
            $operationalExpense->clinic_id === $clinic->id,
            403,
            'Unauthorized'
        );

        if ($request->filled('department_id')) {

            $department = Department::findOrFail(
                $request->department_id
            );

            abort_unless(
                $department->clinic_id === $clinic->id,
                403,
                'Unauthorized department'
            );
        }

        return response()->json(
            $this->service->update(
                $clinic->id,
                $operationalExpense,
                $request->validated()
            )
        );
    }

    public function destroy(
        OperationalExpense $operationalExpense
    ) {
        $clinic = JWTAuth::parseToken()->authenticate();

        abort_unless(
            $operationalExpense->clinic_id === $clinic->id,
            403,
            'Unauthorized'
        );

        $this->service->delete(
            $clinic->id,
            $operationalExpense
        );

        return response()->json([
            'message' => 'Expense deleted successfully'
        ]);
    }
}