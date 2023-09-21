<?php

namespace App\Providers;

use App\Http\Controllers\BookController;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(BookController $bookController): void
    {
        Paginator::useBootstrapFive();

        view()->share('filters', $bookController->setFilters());
    }
}
