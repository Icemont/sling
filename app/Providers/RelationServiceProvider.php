<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class RelationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'user' => 'App\Models\User',
            'client' => 'App\Models\Client',
        ]);
    }
}
