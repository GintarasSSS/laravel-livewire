<?php

namespace App\Providers;

use App\Interfaces\ExpenseRepositoryInterface;
use App\Repositories\ExpenseRepository;
use Illuminate\Support\ServiceProvider;

class ExpenseRepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
    }
}
