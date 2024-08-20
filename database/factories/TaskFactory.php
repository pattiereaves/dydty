<?php

namespace Database\Factories;

use App\Models\Household;
use App\Models\TaskHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'completion_interval' => 86400, // Day in seconds
            // 'household_id' => Household::factory()->createOne()->id,
            'household_id' => Household::factory(),
        ];
    }
}
