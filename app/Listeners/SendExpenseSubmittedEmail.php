<?php

namespace App\Listeners;

use App\Events\ExpenseSubmittedEvent;
use App\Mail\ExpenseSubmitted;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendExpenseSubmittedEmail
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
    public function handle(ExpenseSubmittedEvent $event): void
    {
        $expense = $event->expense;

        $admin = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->first();

        if ($admin !== null) {
            Mail::to($admin->email)->send(new ExpenseSubmitted($expense));
        } else {
            Log::error('Expense submission email not send.');
        }
    }
}
