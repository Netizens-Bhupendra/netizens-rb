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

        // 1️⃣ Load views from package
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ntrolebaseView');

        // 2️⃣ Publish views so users can customize
        $this->publishes([
            __DIR__.'/../resources/views/ntrolebase' => resource_path('views/ntrolebase'),
        ], 'ntrolebase-views');

        $this->loadRoutesFrom(__DIR__.'/../routes/NtRoleBase/nt-rolebase-web-route.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
