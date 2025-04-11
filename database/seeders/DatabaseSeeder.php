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
        // Seed person and contact records first
        $people = Person::factory(20)->create();

        // Create contacts
        $contacts = Contact::factory(20)->create();
        
        // Create admin person
        $adminPerson = Person::create([
            'firstName' => 'Admin',
            'lastName' => 'User',
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);
        
        // Create admin user without personId
        $adminUser = User::create([
            // Remove personId as it doesn't exist in the users table
            'name' => 'AdminUser',
            'email' => 'admin@example.com', 
            'password' => Hash::make('Admin1234'),
            'created_At' => now(),
            'updated_At' => now(),
        ]);
        
        // Create test user manually with existing person and contact
        $testPerson = $people->first();
        $testContact = $contacts->first();

        $testUser = User::create([
            // 'personId' => $testPerson->id,
            // 'contactId' => $testContact->id,
            'email' => 'test@example.com',
            'name' => 'testuser',
            'password' => Hash::make('password'),
            // 'isActive' => true,
            // 'note' => 'Test user account',
            'created_At' => now(),
            'updated_At' => now(),
        ]);

        // Create other users with UserFactory
        $users = User::factory(9)->create();
        $allUsers = User::all();

        // Seed roles for users
        foreach ($allUsers as $user) {
            $roleName = ($user->id === $adminUser->id) ? 'Administrator' : 'Gebruiker';
            Role::factory()->create([
                'userId' => $user->id,
                'name' => $roleName,
            ]);
        }

        // Seed contacts for some of the people
        foreach ($people->random(15) as $person) {
            Contact::factory()->create();
        }

        // Seed scores
        $scores = Score::factory(10)->create();

        // Seed customers
        foreach ($people->random(10) as $person) {
            Customer::factory()->create([
                'personId' => $person->id,
                'scoreId' => $scores->random()->id,
            ]);
        }

        // Seed employees
        foreach ($people->random(5) as $person) {
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
    }
}
