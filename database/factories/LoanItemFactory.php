<?php

namespace Database\Factories;

use App\Models\LoanItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoanItem>
 */
class LoanItemFactory extends Factory
{
    protected $model = LoanItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Laptop', 'Proyektor', 'Kamera', 'Tripod', 'Microphone', 'Keyboard', 'Mouse', 'Monitor']),
        ];
    }
}
