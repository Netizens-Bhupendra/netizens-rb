<?php

namespace Netizens\RB\Tests\NT_RB_Testing\Routes;

use Netizens\RB\Tests\RBTestCase;

class RouteTest extends RBTestCase
{
    public function test_it_can_check_role_base_index_route()
    {
        $response = $this->get('role-base/index');

        $response->assertStatus(200)->assertSee('Welcome to Nt-RB');
    }
}
