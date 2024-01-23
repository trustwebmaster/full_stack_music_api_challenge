<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserFavouriteArtist;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArtistFeatureTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A user can get all favorite artists.
     */
    public function testUserCanGetAllFavoriteArtists()
    {
        // Arrange
        $user = User::factory()->create();
        $token = $this->loginUser($user);

        $this->assertNotNull($token);
        $response = $this->get(route('artists.index', ['token' => $token]));

        $response->assertStatus(200);
    }

    /**
     * A user can create a favorite artist.
     */
    public function testUserCanCreateFavoriteArtist()
    {
        $user = User::factory()->create();
        $token = $this->loginUser($user);

        $this->assertNotNull($token);

        $response = $this->postJson(route('artists.store', ['token' => $token]), [
            'name' => Factory::create()->firstNameMale(),
            'user_id' => $user->id,
        ]);

        $response->assertStatus(201);
    }

    /**
     * A user can get a specific favorite artist.
     */
    public function testUserCanGetCurrentFavoriteArtist()
    {
        $user = User::factory()->create();
        $token = $this->loginUser($user);

        $this->assertNotNull($token);
        $artist = UserFavouriteArtist::factory()->create();


        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->get(route('artists.show', ['artist' => $artist->id]));

        $response->assertSuccessful();
    }

    /**
     * A user can update a favorite artist.
     */
    public function testUserCanUpdateCurrentFavoriteArtist()
    {
        $user = User::factory()->create();
        $token = $this->loginUser($user);

        $this->assertNotNull($token);
        $artist = UserFavouriteArtist::factory()->create();


        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson(route('artists.update', ['artist' => $artist->id]), [
                'name' => 'BTS',
                'user_id' => $user->id,
            ]);

        $response->assertStatus(200);
    }

    /**
     * A user can delete a favorite artist.
     */
    public function testUserCanDeleteCurrentFavoriteArtist()
    {
        $user = User::factory()->create();
        $token = $this->loginUser($user);

        $this->assertNotNull($token);
        $artist = UserFavouriteArtist::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->delete(route('artists.destroy', ['artist' => $artist->id]));

        $response->assertStatus(200);
    }

    /**
     * Log in the user and return the token.
     *
     * @param User $user
     * @return string|null
     */
    private function loginUser(User $user): ?string
    {
        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        return $response->json('access_token');
    }
}
