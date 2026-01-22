<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'Colin Edric Mickynson',
                'email' => 'colinedric04@gmail.com',
                'password' => Hash::make('colinedric'),
            ],
            [
                'name' => 'Declane Joseph Delvino',
                'email' => 'declanecun@gmail.com',
                'password' => Hash::make('declane123'),
            ],
            [
                'name' => 'Jose Keitaro',
                'email' => 'josekeitaro2008@gmail.com',
                'password' => Hash::make('jose321'),
            ]
        ]);
    }
}
