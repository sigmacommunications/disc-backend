<?php

namespace Database\Factories;

use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SongPlay>
 */
class SongPlayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,  // Random user from the existing users
            'track_id' => Track::inRandomOrder()->first()->id,  // Random track from the existing tracks
            'played_at' => $this->faker->dateTimeThisYear(),  // Random played_at time within the current year
        ];
    }
}
