<?php

namespace Database\Factories;

use App\Models\Division;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    protected $model = Loan::class;
    private static array $divisionIds = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (empty(self::$divisionIds)) {
            self::$divisionIds = Division::pluck('id')->toArray();
        }
        
        return [
            'title' => fake()->name(),
            'description' => fake()->sentence(),
            'date' => fake()->date(),
            'division_id' => fake()->randomElement(self::$divisionIds),
        ];
    }
}
