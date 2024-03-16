<?php

namespace Database\Seeders;

use App\Models\SportType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        SportType::insert([
            ['name' => 'Football'],
            ['name' => 'Badminton'],
            ['name' => 'Volleyball'],
            ['name' => 'Basketball'],
            ['name' => 'Ping-pong'],
        ]);
    }
}
