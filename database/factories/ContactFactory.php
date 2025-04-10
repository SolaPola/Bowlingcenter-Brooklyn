<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'phoneNumber' => $this->faker->boolean(80) ? $this->faker->numerify('##########') : null,
            'address' => $this->faker->boolean(80) ? $this->faker->address() : null,
            'isActive' => $this->faker->boolean(90),
            'note' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
