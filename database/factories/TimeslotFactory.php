<?php

namespace Database\Factories;

use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeslotFactory extends Factory
{
    protected $model = Timeslot::class;

    public function definition(): array
    {
        $startHour = $this->faker->numberBetween(10, 21);
        $startTime = sprintf('%02d:00:00', $startHour);
        $endTime = sprintf('%02d:00:00', $startHour + 1);
        
        return [
            'startTime' => $startTime,
            'endTime' => $endTime,
            'day' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'isActive' => $this->faker->boolean(90),
            'note' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
