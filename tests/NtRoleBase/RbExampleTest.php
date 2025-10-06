<?php

namespace Netizens\RB\Tests\NtRoleBase;

use Netizens\RB\NtRoleBaseServiceProvider;
use Orchestra\Testbench\TestCase;

class RbExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            NtRoleBaseServiceProvider::class,
        ];
    }

    public function test_route()
    {
        $response = $this->get('role-base/index');

        $response->assertStatus(200)->assertSee('Welcome to Nt-RB');
    }
}
