<?php

namespace Database\Seeders;

use App\Models\EntryActivity;
use App\Models\User;
use Illuminate\Database\Seeder;

class EntryActivitySeeder extends Seeder
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

        foreach ($users->take(15) as $userId) {
            EntryActivity::factory()
                ->count(rand(1, 5))
                ->create(['user_id' => $userId]);
        }
    }
}
