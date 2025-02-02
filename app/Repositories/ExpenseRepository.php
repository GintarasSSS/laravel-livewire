<?php

namespace App\Repositories;

use App\Interfaces\ExpenseRepositoryInterface;
use App\Models\Expense;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    public function getPendingExpenses(): Collection
    {
        $pendingStatus = Status::where('name', 'pending')->first();

        return Expense::where('status_id', $pendingStatus->id)->with('user')->get();
    }

    public function updateExpenseStatus(int $expenseId, string $statusName): Expense
    {
        $expense = Expense::findOrFail($expenseId);
        $status = Status::where('name', $statusName)->firstOrFail();

        $expense->status_id = $status->id;
        $expense->save();

        return $expense;
    }

    public function createExpense(array $data): Expense
    {
        $data['status_id'] = Status::where('name', 'pending')->first()->id;
        return Expense::create($data);
    }

    public function getUserExpenses(int $userId): Collection
    {
        return Expense::where('user_id', $userId)->get();
    }
}
