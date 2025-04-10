<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'userId' => User::factory(),
            'name' => $this->faker->randomElement(['admin', 'manager', 'employee', 'customer']),
            'isActive' => $this->faker->boolean(90),
            'note' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'createdAt' => now(),
            'updatedAt' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
