<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // First create a person and contact as they are required for the user
        $person = Person::factory()->create();
        $contact = Contact::factory()->create();

        return [
            'personId' => $person->id,
            'contactId' => $contact->id,
            'username' => fake()->unique()->userName(),
            'password' => Hash::make('password'),
            'isActive' => true,
            'note' => fake()->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
