<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // This will create a user and associate it with the artist
            'bio' => $this->faker->text(200),
            'twitter' => $this->faker->url,
            'instagram' => $this->faker->url,
            'facebook' => $this->faker->url,
        ];
    }
}
