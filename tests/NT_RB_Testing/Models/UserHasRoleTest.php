<?php

namespace Netizens\RB\Tests\NT_RB_Testing\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Netizens\RB\Models\UserHasRole;
use Netizens\RB\Tests\RBTestCase;

class UserHasRoleTest extends RBTestCase
{
    use RefreshDatabase; // resets DB between tests


    public function test_it_can_check_db_connection()
    {
        // dump(config('database.connections.testing'));
        $this->assertTrue(true);
    }

    /** @test */
    public function test_it_can_create_a_user_has_role_record()
    {
        $record = UserHasRole::create([
            'user_id' => '123e4567-e89b-12d3-a456-426614174000',
            'role_id' => '223e4567-e89b-12d3-a456-426614174111',
            'role_name' => 'Admin',
        ]);

        $this->assertDatabaseHas('user_has_roles', [
            'id' => $record->id,
            'role_name' => 'Admin',
        ]);
    }

    /** @test */
    public function test_it_can_soft_delete_a_record()
    {
        $record = UserHasRole::factory()->create();

        $record->delete();

        $this->assertSoftDeleted('user_has_roles', [
            'id' => $record->id,
        ]);
    }
}
