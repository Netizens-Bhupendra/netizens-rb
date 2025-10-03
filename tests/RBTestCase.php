<?php

namespace Netizens\RB\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

class RBTestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            \Netizens\RB\NtRoleBaseServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

    }
}
