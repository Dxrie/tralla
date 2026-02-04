<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'HR & Umum',
            'Finance',
            'Engineering',
            'Marketing',
            'Operasional',
            'IT',
            'Customer Service',
            'Produksi',
        ];

        foreach ($names as $name) {
            Division::firstOrCreate(['name' => $name]);
        }
    }
}
