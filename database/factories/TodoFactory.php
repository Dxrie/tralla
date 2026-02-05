<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-2 weeks', 'now');
        $finish = fake()->optional(0.7)->dateTimeBetween($start, '+2 weeks');

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->optional(0.6)->paragraph(),
            'status' => fake()->randomElement(['to-do', 'on progress', 'hold', 'done']),
            'start_date' => $start,
            'finish_date' => $finish,
        ];
    }

    public function todo(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'to-do']);
    }

    public function onProgress(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'on progress']);
    }

    public function done(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'done']);
    }
}
