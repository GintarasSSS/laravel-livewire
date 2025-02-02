<?php

namespace App\Listeners;

use App\Events\ExpenseStatusUpdatedEvent;
use App\Mail\ExpenseStatusUpdated;
use App\Models\Expense;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendExpenseStatusUpdatedEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(ExpenseStatusUpdatedEvent $event): void
    {
        $expense = Expense::with(['user', 'status'])->find($event->expense->id);

        if ($expense !== null) {
            Mail::to($expense->user->email)->send(new ExpenseStatusUpdated($expense));
        } else {
            Log::error('Expense update email not send.');
        }
    }
}
