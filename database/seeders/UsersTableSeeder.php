<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $user->assignRole('user');

        $artist = User::create([
            'name' => 'artist',
            'email' => 'artist@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $artist->assignRole('artist');
        Artist::factory()->create([
            'user_id' => $artist->id,
        ]);

    }
}
