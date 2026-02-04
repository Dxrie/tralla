<?php

namespace Database\Seeders;

use App\Models\ExitActivity;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExitActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'employee')->pluck('id');
        if ($users->isEmpty()) {
            return;
        }

        foreach ($users->take(12) as $userId) {
            ExitActivity::factory()
                ->count(rand(1, 4))
                ->create(['user_id' => $userId]);
        }
    }
}
