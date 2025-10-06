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

        // 1 Load routes from package
        $this->loadRoutesFrom(__DIR__.'/../routes/ntrolebase/ntrb_routes.php');

        // 2 Optional: publish routes if user wants to customize
        $this->publishes([
            __DIR__.'/../routes/ntrolebase/ntrb_routes.php' => base_path('routes/ntrolebase/ntrb_routes.php'),
        ], 'ntrolebase-routes');



        // 3 Publish controllers so users can customize
        $this->publishes([
            __DIR__ . '/Http/Controllers/NtRoleBase' => app_path('Http/Controllers/NtRoleBase'),
        ], 'ntrolebase-controllers');


        // 3 Load views from package
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ntrolebaseView');

        // 4 Publish views so users can customize
        $this->publishes([
            __DIR__.'/../resources/views/ntrolebase' => resource_path('views/ntrolebase'),
        ], 'ntrolebase-views');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
