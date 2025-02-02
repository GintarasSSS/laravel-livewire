<?php

namespace Tests\Feature;

use App\Events\ExpenseStatusUpdatedEvent;
use App\Livewire\AdminPendingExpenses;
use App\Models\Expense;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPendingExpensesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    public function testAdminCanSeePendingExpenses(): void
    {
        $admin = $this->getAdmin();
        $user = $this->getUser();
        $pendingExpense = $this->getPendingExpense($user->id);

        Gate::define('approve-reject', fn() => true);

        Livewire::actingAs($admin)
            ->test(AdminPendingExpenses::class)
            ->assertSee($pendingExpense->description);
    }

    public function testNonAdminCannotSeePendingExpenses(): void
    {
        $user = $this->getUser();

        Livewire::actingAs($user)
            ->test(AdminPendingExpenses::class)
            ->assertForbidden();
    }

    public function testAdminCanUpdateExpenseStatusToApproved(): void
    {
        $admin = $this->getAdmin();
        $user = $this->getUser();
        $pendingExpense = $this->getPendingExpense($user->id);

        Gate::define('approve-reject', fn() => true);

        $status = Status::factory()->create(['name' => 'approved']);

        Livewire::actingAs($admin)
            ->test(AdminPendingExpenses::class)
            ->call('updateStatus', $pendingExpense->id, $status->name);

        $this->assertDatabaseHas('expenses', [
            'id' => $pendingExpense->id,
            'status_id' => $status->id
        ]);
    }

    public function testAdminCanUpdateExpenseStatusToRejected(): void
    {
        $admin = $this->getAdmin();
        $user = $this->getUser();
        $pendingExpense = $this->getPendingExpense($user->id);

        Gate::define('approve-reject', fn() => true);

        $status = Status::factory()->create(['name' => 'rejected']);

        Livewire::actingAs($admin)
            ->test(AdminPendingExpenses::class)
            ->call('updateStatus', $pendingExpense->id, $status->name);

        $this->assertDatabaseHas('expenses', [
            'id' => $pendingExpense->id,
            'status_id' => $status->id
        ]);
    }

    public function testNonAdminCannotAccessToExpenseStatus(): void
    {
        $user = $this->getUser();

        Livewire::actingAs($user)
            ->test(AdminPendingExpenses::class)
            ->assertForbidden();
    }

    public function testExpenseStatusUpdateTriggersEvent(): void
    {
        $admin = $this->getAdmin();
        $user = $this->getUser();
        $pendingExpense = $this->getPendingExpense($user->id);

        Gate::define('approve-reject', fn() => true);

        $status = Status::factory()->create(['name' => 'approved']);

        Livewire::actingAs($admin)
            ->test(AdminPendingExpenses::class)
            ->call('updateStatus', $pendingExpense->id, $status->name);

        Event::assertDispatched(ExpenseStatusUpdatedEvent::class);
    }

    protected function getAdmin(): User
    {
        $role = Role::factory()->create(['name' => 'admin']);
        return User::factory()->create(['role_id' => $role->id]);
    }

    protected function getUser(): User
    {
        $role = Role::factory()->create(['name' => 'user']);
        return User::factory()->create(['role_id' => $role->id]);
    }

    protected function getPendingExpense(int $userId): Expense
    {
        $status = Status::factory()->create(['name' => 'pending']);
        return Expense::factory()->create(['status_id' => $status->id, 'user_id' => $userId]);
    }
}
