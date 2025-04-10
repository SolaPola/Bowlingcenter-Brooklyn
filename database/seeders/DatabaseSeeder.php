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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $users = User::factory(10)->create();
        
        // Seed roles for users
        foreach ($users as $user) {
            Role::factory()->create([
                'userId' => $user->id,
            ]);
        }
        
        // Seed person records
        $people = Person::factory(20)->create();
        
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
        foreach ($customers as $customer) {
            $reservation = Reservation::factory()->create([
                'customerId' => $customer->id,
                'courtId' => $courts->random()->id,
                'timeslotId' => $timeslots->random()->id,
            ]);
            $reservations[] = $reservation;
        }
        
        // Create additional reservations
        $additionalReservations = Reservation::factory(10)->create();
        $reservations = array_merge($reservations, $additionalReservations->toArray());
        
        // Seed orders for each reservation
        foreach ($reservations as $reservation) {
            Order::factory()->create([
                'reservationId' => $reservation->id ?? $reservation['id'],
            ]);
        }
        
        // Create additional orders with new reservations
        Order::factory(5)->create();
    }
}
