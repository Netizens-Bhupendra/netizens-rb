<?php

namespace Netizens\RB\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class RBTestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            \Netizens\RB\NtRoleBaseServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        config()->set('database.connections.testing', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'nt_rb_package_testing'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'Admin@123'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Tell Laravel where to find your factories
        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Netizens\\RB\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );

        // Load your package migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
