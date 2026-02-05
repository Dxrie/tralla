<?php

namespace Database\Factories;

use App\Models\Borrow;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrow>
 */
class BorrowFactory extends Factory
{
    protected $model = Borrow::class;

    private static array $divisiEnum = ['KP', 'MBKM', 'Manajemen', 'Magang PKL'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_barang' => fake()->randomElement(['Laptop', 'Proyektor', 'Kamera', 'Tripod', 'Microphone', 'Keyboard', 'Mouse', 'Monitor']),
            'divisi' => fake()->randomElement(self::$divisiEnum),
            'foto_barang' => 'borrow/' . fake()->uuid() . '.jpg',
        ];
    }
}
