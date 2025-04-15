<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Person;
use App\Models\Contact;
use App\Models\Score;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Court;
use App\Models\Timeslot;
use App\Models\Reservation;
use App\Models\Order;
use App\Models\Spel;
use App\Models\TypePerson;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the three default TypePerson records
        $klantType = TypePerson::create([
            'naam' => 'Klant',
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        $gastType = TypePerson::create([
            'naam' => 'Gast',
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        $medewerkerType = TypePerson::create([
            'naam' => 'Medewerker',
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        // Create contacts first - these will include our supplier contacts
        $contacts = Contact::factory(5)->create();

        // Create only the explicitly defined people
        $people = [];

        // Create admin person with typePerson_id
        $adminPerson = Person::create([
            'typePerson_id' => $medewerkerType->id,
            'firstName' => 'Admin',
            'lastName' => 'User',
            'isAdult' => true, // Add isAdult field
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        // Add a test employee
        $employeePerson = Person::create([
            'typePerson_id' => $medewerkerType->id,
            'firstName' => 'Test',
            'lastName' => 'Employee',
            'isAdult' => true, // Add isAdult field
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        // Add a test customer
        $customerPerson = Person::create([
            'typePerson_id' => $klantType->id,
            'firstName' => 'Test',
            'lastName' => 'Customer',
            'isAdult' => true, // Add isAdult field
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        // Add a test guest
        $guestPerson = Person::create([
            'typePerson_id' => $gastType->id,
            'firstName' => 'Test',
            'lastName' => 'Guest',
            'isAdult' => false, // Add isAdult field
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        // Group people by type for later use
        $supplierPeople = [$employeePerson, $adminPerson];
        $customerPeople = [$customerPerson];
        $guestPeople = [$guestPerson];
        $people = array_merge($supplierPeople, $customerPeople, $guestPeople);

        // Create admin user
        $adminUser = User::create([
            'name' => 'AdminUser',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin1234'),
            'created_At' => now(),
            'updated_At' => now(),
        ]);

        // Create test user with first person and contact
        $testPerson = $employeePerson;
        $testContact = $contacts[0];

        $testUser = User::create([
            'email' => 'test@example.com',
            'name' => 'testuser',
            'password' => Hash::make('password'),
            'created_At' => now(),
            'updated_At' => now(),
        ]);

        // Create other users with UserFactory
        $allUsers = User::all();

        // Seed roles for users
        foreach ($allUsers as $user) {
            $roleName = ($user->id === $adminUser->id) ? 'Administrator' : 'Gebruiker';
            Role::factory()->create([
                'userId' => $user->id,
                'name' => $roleName,
            ]);
        }

        // Associate people with contacts where appropriate
        // First 7 contacts are supplier contacts
        for ($i = 0; $i < 5; $i++) {
            // Link supplier people with their contacts
            // Code for linking would go here if your models have a relationship between Person and Contact
        }

        // Seed scores
        $scores = Score::factory(10)->create();

        // Seed customers - use the customer people array
        foreach ($customerPeople as $person) {
            // Create a score for this customer
            $score = Score::factory()->create();

            Customer::factory()->create([
                'personId' => $person->id,
                'scoreId' => $score->id,
            ]);
        }

        // Seed employees - use the supplier people and admin
        foreach ($supplierPeople as $person) {
            Employee::factory()->create([
                'personId' => $person->id,
            ]);
        }

        // Seed courts
        $courts = Court::factory(8)->create();

        // Seed timeslots
        $timeslots = Timeslot::factory(10)->create();

        // Get all customers for reservations
        $customers = Customer::all();

        // Seed reservations
        $reservations = [];

        // Create an array to track used combinations
        $usedCombinations = [];

        // Create a reservation for each customer with unique court/timeslot/date combinations
        foreach ($customers as $customer) {
            // Keep trying until we get a unique combination
            $uniqueCombinationFound = false;
            $maxAttempts = 50; // Limit attempts to prevent infinite loop
            $attempt = 0;

            while (!$uniqueCombinationFound && $attempt < $maxAttempts) {
                $courtId = $courts->random()->id;
                $timeslotId = $timeslots->random()->id;
                $date = fake()->dateTimeBetween('-1 month', '+2 months')->format('Y-m-d');

                $combinationKey = "{$courtId}_{$timeslotId}_{$date}";

                // If combination is unique, create reservation
                if (!isset($usedCombinations[$combinationKey])) {
                    $reservation = Reservation::factory()->create([
                        'customerId' => $customer->id,
                        'courtId' => $courtId,
                        'timeslotId' => $timeslotId,
                        'date' => $date,
                    ]);

                    $reservations[] = $reservation;
                    $usedCombinations[$combinationKey] = true;
                    $uniqueCombinationFound = true;
                }

                $attempt++;
            }
        }

        // Create additional reservations with unique combinations
        $additionalReservations = [];
        for ($i = 0; $i < 10; $i++) {
            $uniqueCombinationFound = false;
            $maxAttempts = 50;
            $attempt = 0;

            while (!$uniqueCombinationFound && $attempt < $maxAttempts) {
                $courtId = $courts->random()->id;
                $timeslotId = $timeslots->random()->id;
                $date = fake()->dateTimeBetween('-1 month', '+2 months')->format('Y-m-d');

                $combinationKey = "{$courtId}_{$timeslotId}_{$date}";

                if (!isset($usedCombinations[$combinationKey])) {
                    $reservation = Reservation::factory()->create([
                        'courtId' => $courtId,
                        'timeslotId' => $timeslotId,
                        'date' => $date,
                    ]);

                    $additionalReservations[] = $reservation;
                    $usedCombinations[$combinationKey] = true;
                    $uniqueCombinationFound = true;
                }

                $attempt++;
            }
        }

        $allReservations = array_merge($reservations, $additionalReservations);

        // Seed orders for each reservation
        foreach ($allReservations as $reservation) {
            Order::factory()->create([
                'reservationId' => $reservation->id,
            ]);
        }

        // Create additional orders with new reservations
        for ($i = 0; $i < 5; $i++) {
            // Create a new reservation with unique combination
            $uniqueCombinationFound = false;
            $maxAttempts = 50;
            $attempt = 0;

            while (!$uniqueCombinationFound && $attempt < $maxAttempts) {
                $courtId = $courts->random()->id;
                $timeslotId = $timeslots->random()->id;
                $date = fake()->dateTimeBetween('-1 month', '+2 months')->format('Y-m-d');

                $combinationKey = "{$courtId}_{$timeslotId}_{$date}";

                if (!isset($usedCombinations[$combinationKey])) {
                    $newReservation = Reservation::factory()->create([
                        'courtId' => $courtId,
                        'timeslotId' => $timeslotId,
                        'date' => $date,
                    ]);

                    Order::factory()->create([
                        'reservationId' => $newReservation->id,
                        'packageType' => fake()->randomElement(['snackpakket basis', 'snackpakket Luxe', 'kinderpartij', 'Vrijgezellenfeest ']),
                    ]);

                    $usedCombinations[$combinationKey] = true;
                    $uniqueCombinationFound = true;
                }

                $attempt++;
            }
        }

        // After creating all reservations, create spel records
        $allReservations = Reservation::all();
        $allPeople = Person::all();

        // Create at least one spel record for each reservation
        foreach ($allReservations as $reservation) {
            // Create 1-4 spel records per reservation (people playing)
            $spelCount = fake()->numberBetween(1, 4);

            for ($i = 0; $i < $spelCount; $i++) {
                // Randomly select a person
                $randomPerson = $allPeople->random();

                Spel::create([
                    'personId' => $randomPerson->id,
                    'reservationId' => $reservation->id,
                    'isActive' => true,
                    'note' => fake()->boolean(20) ? fake()->sentence() : null, // 20% chance of having a note
                    'createdAt' => now(),
                    'updatedAt' => now(),
                ]);
            }
        }

        // Create some standalone spel records
        for ($i = 0; $i < 10; $i++) {
            Spel::factory()->create();
        }

        // Seed static reservations
        $staticReservations = (new \Database\Factories\ReservationFactory())->staticReservations();
        foreach ($staticReservations as $reservationData) {
            Reservation::create($reservationData);
        }
    }
}
