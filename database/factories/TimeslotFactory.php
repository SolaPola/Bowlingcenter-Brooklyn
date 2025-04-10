<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TimeslotFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->time('H:i:s');
        $end = date('H:i:s', strtotime($start . ' +1 hour'));

        return [
            'startTime' => $start,
            'endTime' => $end,
            'day' => fake()->dayOfWeek(),
            'isActive' => true,
            'note' => fake()->optional()->sentence(),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
