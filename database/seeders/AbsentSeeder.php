<?php

namespace Database\Seeders;

use App\Models\Absent;
use App\Models\User;
use Illuminate\Database\Seeder;

class AbsentSeeder extends Seeder
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

        $userIds = $users->random(min(8, $users->count()));
        foreach ($userIds as $userId) {
            Absent::factory()
                ->count(rand(1, 3))
                ->create(['user_id' => $userId]);
        }
    }
}
