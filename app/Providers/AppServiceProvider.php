<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Violation;
use App\Observers\ViolationObserver;
use Illuminate\Support\Carbon;


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
        Violation::observe(ViolationObserver::class);
        Carbon::setLocale(config('app.locale'));
    }
}
