<?php

namespace App\Providers;

use App\Services\DomainCheckerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DomainCheckerService::class, function () {
            return new DomainCheckerService(
                env('WHOIS_API_URL'),
                env('WHOIS_API_KEY'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
