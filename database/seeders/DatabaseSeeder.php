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
        
        // Maak een admin en testgebruiker (specifieke users)
        $person = Person::factory()->create([
            'firstName' => fake()->firstName,
            'infix' => fake()->optional()->lastName,
            'lastName' => fake()->lastName,
        ]);

        $customer = Customer::create([
            'personId' => $person->id,
            'scoreId' => Score::factory()->create()->id, // Add a score relationship
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        Contact::create([
            'email' => 'test@gmail.com',
            'phoneNumber' => fake()->phoneNumber,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        User::create([
            'personId' => $person->id,
            'name' => 'TestUser',
            'password' => Hash::make('Test1234'),
        ]);

        $adminPerson = Person::factory()->create([
            'firstName' => fake()->firstName,
            'infix' => fake()->optional()->lastName,
            'lastName' => fake()->lastName,
        ]);

        $adminCustomer = Customer::create([
            'personId' => $adminPerson->id,
            'scoreId' => Score::factory()->create()->id, // Add a score relationship
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        Contact::create([
            'email' => 'admin@gmail.com',
            'phoneNumber' => fake()->phoneNumber,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        $adminUser = User::create([
            'personId' => $adminPerson->id,
            'name' => 'AdminUser',
            'password' => Hash::make('Admin1234'),
        ]);

        $adminRole = Role::create([
            'userId' => $adminUser->id,
            'name' => 'Admin',
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        // Associate the role with the user
        $adminUser->roles()->save($adminRole);

        Employee::create([
            'personId' => $adminPerson->id,
            'function' => 'System Management',
            'employee_type' => 'Administrator',
            'isActive' => true,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);

        // Nu de rest van de gebruikers (gekoppeld aan een persoon)
        $users = User::factory()->count(10)->create();
        $allUsers = User::all();

        // Werknemers aanmaken (gekoppeld aan een persoon)
        $employees = Employee::factory()->count(10)->create();
        
        // Seed roles for users
        foreach ($allUsers as $user) {
            Role::factory()->create([
                'userId' => $user->id,
                'createdAt' => now(),
                'updatedAt' => now(),
            ]);
        }
        
        // Seed scores
        $scores = Score::factory(10)->create();
        
        // Seed customers for remaining people who don't already have associations
        $usedPeopleIds = Customer::pluck('personId')->toArray();
        $availablePeople = $people->filter(function ($person) use ($usedPeopleIds) {
            return !in_array($person->id, $usedPeopleIds);
        })->take(10);
        
        foreach ($availablePeople as $person) {
            Customer::factory()->create([
                'personId' => $person->id,
                'scoreId' => $scores->random()->id,
                'createdAt' => now(),
                'updatedAt' => now(),
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
                    ]);
                    
                    $usedCombinations[$combinationKey] = true;
                    $uniqueCombinationFound = true;
                }
                
                $attempt++;
            }
        }
    }
}
