<?php

namespace Database\Factories;

use App\Models\Subtask;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subtask>
 */
class SubtaskFactory extends Factory
{
    protected $model = Subtask::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'todo_id' => Todo::factory(),
            'name' => fake()->sentence(3),
            'is_done' => fake()->boolean(30),
        ];
    }

    public function done(): static
    {
        return $this->state(fn (array $attributes) => ['is_done' => true]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => ['is_done' => false]);
    }
}
