<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\SportType;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

        User::insert([
            [
                'name' => 'Admin Admin',
                'phone' => '85592694905',
                'password' => '$2y$12$ryRZosbotrrhcUybdX02yeRqcOhFfVjoqQDGedkPjy/qxAAFngYnK',
                'is_admin' => 1,
                'is_verified' => 1,
            ],
            [
                'name' => 'Anakin Skywalker',
                'phone' => '855696969',
                'password' => '$2y$12$ryRZosbotrrhcUybdX02yeRqcOhFfVjoqQDGedkPjy/qxAAFngYnK',
                'is_admin' => 0,
                'is_verified' => 1,
            ],
            [
                'name' => 'Obi wan Kenobi',
                'phone' => '855420420',
                'password' => '$2y$12$ryRZosbotrrhcUybdX02yeRqcOhFfVjoqQDGedkPjy/qxAAFngYnK',
                'is_admin' => 0,
                'is_verified' => 1,
            ],
        ]);
    }
}
