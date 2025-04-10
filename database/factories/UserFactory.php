<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'contactId' => Contact::factory(),
            'personId' => Person::factory(),
            'name' => $this->faker->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'is_logged_in' => false,
            'logged_in' => null,
            'logged_out' => null,
            'is_active' => true,
            'note' => $this->faker->boolean(20) ? $this->faker->sentence() : null,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'admin',
        ]);
    }
}
