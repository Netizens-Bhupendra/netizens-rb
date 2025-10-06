<?php

namespace Netizens\RB\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Netizens\RB\Models\UserHasRole;

class UserHasRoleFactory extends Factory
{
    protected $model = UserHasRole::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->uuid,
            'role_id' => $this->faker->uuid,
            'role_name' => $this->faker->word,
        ];
    }
}
