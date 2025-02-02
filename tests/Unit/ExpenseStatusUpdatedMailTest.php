<?php

use App\Mail\ExpenseStatusUpdated;
use App\Models\Expense;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ExpenseStatusUpdatedMailTest extends TestCase
{
    use RefreshDatabase;

    public function testExpenseStatusUpdatedMail(): void
    {
        $user = $this->getUser();
        $pendingExpense = $this->getPendingExpense($user->id);

        Mail::fake();

        Mail::to('user@example.com')->send(new ExpenseStatusUpdated($pendingExpense));

        Mail::assertSent(ExpenseStatusUpdated::class);
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
