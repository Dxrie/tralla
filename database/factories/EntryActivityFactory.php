<?php

namespace Database\Factories;

use App\Models\EntryActivity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EntryActivity>
 */
class EntryActivityFactory extends Factory
{
    protected $model = EntryActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status' => fake()->randomElement(['ontime', 'late']),
            'image_path' => 'absensi_masuk/' . fake()->unique()->uuid() . '.jpg',
        ];
    }

    public function ontime(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'ontime']);
    }

    public function late(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'late']);
    }
}
