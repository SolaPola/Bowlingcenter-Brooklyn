<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'phoneNumber' => substr($this->faker->numerify('##########'), 0, 15), // Ensure it's within 15 chars
            'address' => $this->faker->address(),
            'isActive' => true,
            'note' => $this->faker->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
