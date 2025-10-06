<?php

namespace Netizens\RB;

use Netizens\RB\Commands\NtRoleBaseCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NtRoleBaseServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('pckg-ntrolebase')
            ->hasConfigFile()
            // ->hasViews('ntrolebase')
            ->hasMigration('create_migration_table_name_table')
            ->hasCommand(NtRoleBaseCommand::class);
    }

    public function boot(): void
    {
        parent::boot();

        // // 1 Load routes from package
        // $this->loadRoutesFrom(__DIR__.'/../routes/ntrolebase/ntrb_routes.php');

        // // 2 Optional: publish routes if user wants to customize
        // $this->publishes([
        //     __DIR__.'/../routes/ntrolebase/ntrb_routes.php' => base_path('routes/ntrolebase/ntrb_routes.php'),
        // ], 'ntrolebase-routes');

        // // 3 Publish controllers so users can customize
        // $this->publishes([
        //     __DIR__.'/Http/Controllers/NtRoleBase' => app_path('Http/Controllers/NtRoleBase'),
        // ], 'ntrolebase-controllers');

        // // 3 Load views from package
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'ntrolebaseView');

        // // 4 Publish views so users can customize
        // $this->publishes([
        //     __DIR__.'/../resources/views/ntrolebase' => resource_path('views/ntrolebase'),
        // ], 'ntrolebase-views');

        // // 5 Load migrations from package
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/ntrolebase');

        // // 6 Publish migrations so user can run them
        // $this->publishes([
        //     __DIR__ . '/../database/migrations/ntrolebase' => database_path('migrations/ntrolebase'),
        // ], 'ntrolebase-migrations');

        // 1 Load package migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations/ntrolebase');

        // 2 Load package routes
        $this->loadRoutesFrom(__DIR__.'/../routes/ntrolebase/ntrb_routes.php');

        // 3 Load package views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ntrolebaseView');

        // Publish everything under one tag
        $this->publishes([
            __DIR__.'/../routes/ntrolebase/ntrb_routes.php' => base_path('routes/ntrolebase/ntrb_routes.php'),
            __DIR__.'/Http/Controllers/NtRoleBase' => app_path('Http/Controllers/NtRoleBase'),
            __DIR__.'/../resources/views/ntrolebase' => resource_path('views/ntrolebase'),
            __DIR__.'/../database/migrations/ntrolebase' => database_path('migrations/ntrolebase'),
        ], 'ntrolebase-all');
    }
}
