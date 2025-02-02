<?php

namespace App\Livewire;

use App\Events\ExpenseStatusUpdatedEvent;
use App\Repositories\ExpenseRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class AdminPendingExpenses extends Component
{
    public $expenses;
    public $expenseId;
    public $newStatus;

    protected ExpenseRepository $repository;

    public function __construct()
    {
        $this->repository = app(ExpenseRepository::class);
    }

    public function mount(): void
    {
        if (Gate::denies('approve-reject')) {
            abort(403, 'Admins are not allowed to submit expenses.');
        }

        $this->expenses = $this->repository->getPendingExpenses();
    }

    public function updateStatus($expenseId, $newStatus): void
    {
        if (Gate::denies('approve-reject')) {
            abort(403, 'Admins are not allowed to submit expenses.');
        }

        $this->expenseId = $expenseId;
        $this->newStatus = $newStatus;

        $this->validate([
            'expenseId' => 'required|exists:expenses,id',
            'newStatus' => 'required|string|in:approved,rejected'
        ]);

        $expense = $this->repository->updateExpenseStatus($this->expenseId, $this->newStatus);

        event(new ExpenseStatusUpdatedEvent($expense));

        $this->mount();

        session()->flash('message', 'Expense status updated successfully!');
    }

    public function render(): Factory|View
    {
        return view('livewire.admin-pending-expenses');
    }
}
