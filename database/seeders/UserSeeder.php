<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = Division::all();
        if ($divisions->isEmpty()) {
            $this->command->warn('Run DivisionSeeder first. Skipping users.');
            return;
        }

        // Fixed employer for login
        User::firstOrCreate(
            ['email' => 'employer1@gmail.com'],
            [
                'name' => 'Employer 1',
                'password' => Hash::make('12345'),
                'role' => 'employer',
                'division_id' => null,
            ]
        );

        // Employees with divisions
        User::factory()
            ->count(20)
            ->employee()
            ->create()
            ->each(fn (User $user) => $user->update(['division_id' => $divisions->random()->id]));
    }
}
