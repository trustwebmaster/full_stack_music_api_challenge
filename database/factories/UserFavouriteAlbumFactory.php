<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserFavouriteAlbum>
 */
class UserFavouriteAlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'artist_name' => fake()->firstNameMale(),
            'album_slug' => fake()->url(),
            'user_id' => auth()->user()->id,
        ];
    }
}
