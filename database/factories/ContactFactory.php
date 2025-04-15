<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    private static $index = 0;

    private static $contacts = [
        [
            'email' => 'm.jamil@gmail.com',
            'phoneNumber' => '0612365478',
            'address' => 'Straat 1, Stad',
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'email' => 'a.ruijter@gmail.com',
            'phoneNumber' => '0637264532',
            'address' => 'Straat 2, Stad',
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'email' => 'h.odijk@gmail.com',
            'phoneNumber' => '0639451238',
            'address' => 'Straat 3, Stad',
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'email' => 'd.van.wakeren@gmail.com',
            'phoneNumber' => '0693234612',
            'address' => 'Straat 4, Stad',
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
        [
            'email' => 'w.van.de.grift@gmail.com',
            'phoneNumber' => '0693234694',
            'address' => 'Straat 5, Stad',
            'isActive' => true,
            'note' => null,
            'createdAt' => '2024-01-01 00:00:00',
            'updatedAt' => '2024-01-01 00:00:00',
        ],
    ];
    

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // First create a new person if one doesn't exist
        $person = Person::factory()->create();

        // If we've used all predefined contacts, start generating random ones
        if (self::$index >= count(self::$contacts)) {
            return [
                'personId' => $person->id,
                'email' => $this->faker->unique()->safeEmail(),
                'phoneNumber' => substr($this->faker->numerify('##########'), 0, 15),
                'address' => $this->faker->address(),
                'isActive' => true,
                'note' => $this->faker->sentence(),
                'createdAt' => now(),
                'updatedAt' => now(),
            ];
        }
        
        $contact = self::$contacts[self::$index];
        self::$index++;
        return array_merge(['personId' => $person->id], $contact);
    }
}
