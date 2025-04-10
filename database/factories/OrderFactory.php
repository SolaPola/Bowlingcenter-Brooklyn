<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'reservationId' => Reservation::factory(),
            'orderNumber' => $this->faker->unique()->numberBetween(10000, 99999),
            'orderDate' => $this->faker->date(),
            'isActive' => $this->faker->boolean(90),
            'note' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
