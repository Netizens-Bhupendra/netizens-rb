<?php

namespace Netizens\RB;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Netizens\RB\Commands\NtRoleBaseCommand;

class NtRoleBaseServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('pckg-ntrolebase')
            ->hasConfigFile()
            ->hasViews('ntrolebase')
            ->hasMigration('create_migration_table_name_table')
            ->hasCommand(NtRoleBaseCommand::class);
    }

    public function boot(): void
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ntrolebaseView');
        $this->loadRoutesFrom(__DIR__ . '/../routes/NtRoleBase/nt-rolebase-web-route.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        
    }
}
