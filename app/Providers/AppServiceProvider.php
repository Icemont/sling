<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\AuthenticatedUserService;
use App\Traits\AuthenticatedUser;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use AuthenticatedUser;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(AuthenticatedUserService::class, function () {
            return new AuthenticatedUserService(
                $this->getAuthenticatedUser()
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
