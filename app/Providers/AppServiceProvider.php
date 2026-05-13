<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\ProductQuestion;
use App\Observers\OrderObserver;
use App\Observers\ProductQuestionObserver;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Fix for Laravel 10 migration repository bug
        // The config returns an array but the repository expects a string
        $this->app->extend('migration.repository', function ($repository, $app) {
            $migrationsConfig = $app['config']['database.migrations'];
            $table = is_array($migrationsConfig) ? ($migrationsConfig['table'] ?? 'migrations') : $migrationsConfig;

            return new DatabaseMigrationRepository($app['db'], $table);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        Order::observe(OrderObserver::class);
        ProductQuestion::observe(ProductQuestionObserver::class);
    }
}
