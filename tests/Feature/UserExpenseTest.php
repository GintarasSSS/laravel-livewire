<?php

namespace Tests\Feature;

use App\Events\ExpenseSubmittedEvent;
use App\Livewire\UserExpenses;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestCase;

class UserExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    public function testUsersCanSubmitExpenses(): void
    {
        $role = Role::factory()->create(['name' => 'user']);
        $user = User::factory()->create(['role_id' => $role->id]);
        Auth::login($user);

        $status = Status::factory()->create(['name' => 'pending']);

        Livewire::test(UserExpenses::class)
            ->set('description', 'Lunch Meeting')
            ->set('amount', 1500)
            ->set('category', 'Food')
            ->call('submit');

        $this->assertDatabaseHas('expenses', [
            'description' => 'Lunch Meeting',
            'amount' => 150000,
            'category' => 'Food',
            'user_id' => $user->id,
            'status_id' => $status->id
        ]);

        Event::assertDispatched(ExpenseSubmittedEvent::class);
    }
}
