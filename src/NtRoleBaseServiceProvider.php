<?php

namespace Netizens\RB;

use Illuminate\Support\Facades\File;
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

        /**
         * 🔹 ROUTES — Prefer published, fallback to vendor
         */
        $routePath = base_path('routes/ntrolebase/ntrb_routes.php');
        if (! File::exists($routePath)) {
            $routePath = __DIR__.'/../routes/ntrolebase/ntrb_routes.php';
        }
        $this->loadRoutesFrom($routePath);

        /**
         * 🔹 CONTROLLERS — Allow override from published app controller
         */
        $publishedController = app_path('Http/Controllers/NtRoleBase/NtRoleBaseController.php');
        if (File::exists($publishedController)) {
            include_once $publishedController;
        }

        /**
         * 🔹 VIEWS — Prefer published, fallback to vendor
         */
        $this->loadViewsFrom([resource_path('views/ntrolebase'), __DIR__.'/../resources/views'], 'ntrolebaseView');

        /**
         * 🔹 MIGRATIONS — Prefer published, fallback to vendor
         */
        $migrationPath = database_path('migrations/ntrolebase');
        if (! File::exists($migrationPath)) {
            $migrationPath = __DIR__.'/../database/migrations/ntrolebase';
        }
        $this->loadMigrationsFrom($migrationPath);

        /**
         * 🔹 PUBLISH ALL ASSETS (Single unified tag)
         */
        $this->publishes([
            __DIR__.'/../routes/ntrolebase/ntrb_routes.php' => base_path('routes/ntrolebase/ntrb_routes.php'),
            __DIR__.'/Http/Controllers/NtRoleBase' => app_path('Http/Controllers/NtRoleBase'),
            __DIR__.'/../resources/views/ntrolebase' => resource_path('views/ntrolebase'),
            __DIR__.'/../database/migrations/ntrolebase' => database_path('migrations/ntrolebase'),
        ], 'ntrolebase-all');

        /**
         * 🔹 AUTO-FIX NAMESPACE in published files (optional but handy)
         * Runs only in console when publishing
         */
        if ($this->app->runningInConsole()) {
            $publishedFiles = [
                $publishedController => [
                    'Netizens\\RB\\Http\\Controllers\\NtRoleBase',
                    'App\\Http\\Controllers\\NtRoleBase',
                ],
                base_path('routes/ntrolebase/ntrb_routes.php') => [
                    'Netizens\\RB\\Http\\Controllers\\NtRoleBase',
                    'App\\Http\\Controllers\\NtRoleBase',
                ],
            ];

            foreach ($publishedFiles as $file => [$search, $replace]) {
                if (File::exists($file)) {
                    File::put($file, str_replace($search, $replace, File::get($file)));
                }
            }
        }
    }
}
