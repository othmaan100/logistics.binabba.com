<?php

namespace App\Providers;

use App\Models\Organization;
use Illuminate\Support\Facades\View;
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
    public function boot(): void
    {
        // Every view gets $organization: the saved details, or null before first-run setup
        View::composer('*', function ($view) {
            $view->with('organization', Organization::current());
        });
    }
}
