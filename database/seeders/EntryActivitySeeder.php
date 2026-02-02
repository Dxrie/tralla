<?php

namespace Database\Seeders;

use App\Models\EntryActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntryActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EntryActivity::factory()->count(15)->create();
    }
}
