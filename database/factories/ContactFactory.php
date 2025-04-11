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

    private static $index = 0;

    private static $contacts = [
        [
            'email' => 'info@venco.nl',
            'phoneNumber' => '0570-123456',
            'address' => 'Suikerweg 123, Deventer',
            'isActive' => true,
            'note' => 'Leverancier van drop producten',
            'createdAt' => '2024-11-22 00:00:00',
            'updatedAt' => '2024-11-22 00:00:00',
        ],
        
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // If we've used all predefined contacts, start generating random ones
        if (self::$index >= count(self::$contacts)) {
            return [
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
        return $contact;
    }
}
