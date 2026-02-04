<?php

namespace Database\Seeders;

use App\Models\Subtask;
use App\Models\Todo;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todo::factory()
            ->count(15)
            ->create()
            ->each(function (Todo $todo) {
                Subtask::factory()
                    ->count(rand(0, 4))
                    ->create(['todo_id' => $todo->id]);
            });
    }
}
