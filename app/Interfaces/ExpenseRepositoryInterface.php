<?php

namespace App\Interfaces;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseRepositoryInterface
{
    public function getPendingExpenses(): Collection;
    public function updateExpenseStatus(int $expenseId, string $statusName): Expense;

    public function createExpense(array $data): Expense;
    public function getUserExpenses(int $userId): Collection;
}
