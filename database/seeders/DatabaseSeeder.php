<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\SportType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
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

        Amenity::insert([
            ['name' => 'Parking'],
            ['name' => 'Drinking Water'],
            ['name' => 'First Aid'],
            ['name' => 'Rest Room'],
            ['name' => 'Change Room'],
        ]);

        User::create([
            'name' => 'Admin Admin',
            'is_admin' => 1,
        ]);
    }
}
