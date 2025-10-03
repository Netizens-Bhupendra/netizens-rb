<?php

namespace Netizens\RB\Tests\Models;

use Netizens\RB\Models\UserHasRole;
use Netizens\RB\NtRoleBaseServiceProvider;
use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserHasRoleTest extends TestCase
{
    use RefreshDatabase; // resets DB between tests

    protected function getPackageProviders($app)
    {
        return [
            NtRoleBaseServiceProvider::class,
        ];
    }

    /** It will require sqlite database to run testcase*/

    // /** @test */
    // public function test_it_can_create_a_user_has_role_record()
    // {
    //     // Create a record
    //     $record = UserHasRole::create([
    //         'user_id' => '123e4567-e89b-12d3-a456-426614174000',
    //         'role_id' => '223e4567-e89b-12d3-a456-426614174111',
    //         'role_name' => 'Admin',
    //     ]);

    //     $this->assertDatabaseHas('user_has_roles', [
    //         'id' => $record->id,
    //         'role_name' => 'Admin',
    //     ]);
    // }

    // /** @test */
    // public function test_it_can_soft_delete_a_record()
    // {
    //     $record = UserHasRole::factory()->create();

    //     $record->delete();

    //     $this->assertSoftDeleted('user_has_roles', [
    //         'id' => $record->id,
    //     ]);
    // }
}
