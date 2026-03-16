<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
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
            'note_id' => Note::factory(),
            'content' => fake()->sentence(),
            'is_completed' => fake()->boolean(30),
            'position' => fake()->numberBetween(0, 100),
        ];
    }
}
