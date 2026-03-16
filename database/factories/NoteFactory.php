<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'board_id' => null,
            'position' => fake()->numberBetween(0, 100),
        ];
    }

    public function withBoard(int $boardId): self
    {
        return $this->state(fn (array $attributes) => [
            'board_id' => $boardId,
        ]);
    }

    public function unassigned(): self
    {
        return $this->state(fn (array $attributes) => [
            'board_id' => null,
        ]);
    }
}
