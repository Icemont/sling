<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use App\Services\AuthenticatedUserService;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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

    /**
     * @throws Exception
     */
    private function getAuthenticatedUser(): User
    {
        $authenticatedUser = auth()->user();

        if (!$authenticatedUser instanceof User) {
            throw new Exception('Can not get authenticated user');
        }

        return $authenticatedUser;
    }
}
