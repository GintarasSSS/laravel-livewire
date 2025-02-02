<?php

use App\Mail\ExpenseSubmitted;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\Status;
use App\Models\Role;
use App\Models\User;

class ExpenseSubmittedMailTest extends TestCase
{
    use RefreshDatabase;

    public function testExpenseSubmittedMail(): void
    {
        $user = $this->getUser();
        $pendingExpense = $this->getPendingExpense($user->id);

        Mail::fake();

        Mail::to('admin@example.com')->send(new ExpenseSubmitted($pendingExpense));

        Mail::assertSent(ExpenseSubmitted::class);
    }

    protected function getPendingExpense(int $userId): Expense
    {
        $status = Status::factory()->create(['name' => 'pending']);
        return Expense::factory()->create(['status_id' => $status->id, 'user_id' => $userId]);
    }

    protected function getUser(): User
    {
        $role = Role::factory()->create(['name' => 'user']);
        return User::factory()->create(['role_id' => $role->id]);
    }
}
