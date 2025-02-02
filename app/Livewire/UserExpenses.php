<?php

namespace App\Livewire;

use App\Events\ExpenseSubmittedEvent;
use App\Repositories\ExpenseRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserExpenses extends Component
{
    use WithFileUploads;

    public $description;
    public $amount;
    public $category;
    public $receipt;

    protected ExpenseRepository $repository;

    public function __construct()
    {
        $this->repository = app(ExpenseRepository::class);
    }

    public function mount(): void
    {
        if (Gate::allows('create')) {
            abort(403, 'Admins are not allowed to submit expenses.');
        }
    }

    public function submit(): void
    {
        if (Gate::allows('create')) {
            session()->flash('error', 'Admins are not allowed to submit expenses.');
            return;
        }

        $this->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string',
            'receipt' => 'nullable|image|mimes:jpg,png|max:2048'
        ]);

        $receiptPath = $this->receipt ? $this->receipt->store('receipts', 'public') : null;

        $expense = $this->repository->createExpense([
            'user_id' => Auth::id(),
            'description' => $this->description,
            'amount' => $this->amount * 100,
            'category' => $this->category,
            'receipt_path' => $receiptPath,
        ]);

        event(new ExpenseSubmittedEvent($expense));

        session()->flash('message', 'Expense submitted successfully!');

        $this->reset();
    }

    public function render(): Factory|View
    {
        $userExpenses = $this->repository->getUserExpenses(Auth::id());

        return view('livewire.user-expenses', compact('userExpenses'));
    }
}
