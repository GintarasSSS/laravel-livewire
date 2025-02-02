<?php

namespace Tests\Unit;

use App\Interfaces\ExpenseRepositoryInterface;
use App\Mail\ExpenseStatusUpdated;
use App\Mail\ExpenseSubmitted;
use App\Models\Expense;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Repositories\ExpenseRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ExpenseRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ExpenseRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(ExpenseRepository::class);
    }

    public function testCreateExpense(): void
    {
        $status = Status::factory()->create(['name' => 'pending']);
        $user = $this->getUser();

        $expenseData = [
            'user_id' => $user->id,
            'description' => 'Business Lunch',
            'amount' => 5000,
            'category' => 'Food',
            'receipt_path' => 'receipts/test.jpg'
        ];

        $expense = $this->repository->createExpense($expenseData);

        $this->assertDatabaseHas('expenses', ['description' => 'Business Lunch']);
        $this->assertEquals($status->id, $expense->status_id);
    }

    public function testUpdateExpenseStatus(): void
    {
        $pending = Status::factory()->create(['name' => 'pending']);
        $approved = Status::factory()->create(['name' => 'approved']);
        $user = $this->getUser();
        $expense = Expense::factory()->create(['status_id' => $pending->id, 'user_id' => $user->id]);

        $updatedExpense = $this->repository->updateExpenseStatus($expense->id, $approved->name);

        $this->assertEquals($approved->id, $updatedExpense->status_id);
    }

    protected function getUser(): User
    {
        $role = Role::factory()->create(['name' => 'user']);
        return User::factory()->create(['role_id' => $role->id]);
    }
}
