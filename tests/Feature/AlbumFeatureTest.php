<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserFavouriteAlbum;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Psy\Util\Str;
use Tests\TestCase;

class AlbumFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user can get all favorite albums.
     */
    public function testUserCanGetAllFavoriteAlbums()
    {
        // Arrange
        $user = User::factory()->create();
        $token = $this->loginUser($user);

        $this->assertNotNull($token);
        $response = $this->get(route('albums.index', ['token' => $token]));

        $response->assertStatus(200);
    }

    /**
     * A user can create a favorite album.
     */
    public function testUserCanCreateFavoriteAlbum()
    {
        $user = User::factory()->create();
        $token = $this->loginUser($user);

        $this->assertNotNull($token);

        $response = $this->postJson(route('albums.store', ['token' => $token]), [
            'name' => Factory::create()->name,
            'artist_name' => Factory::create()->firstNameMale,
            'user_id' => $user->id,
        ]);

        $response->assertStatus(201);

    }

    /**
     * A user can get a specific favorite album.
     */
    public function testUserCanGetCurrentFavoriteAlbum()
    {
        $user = User::factory()->create();
        $token = $this->loginUser($user);

        $this->assertNotNull($token);

        $response = $this->postJson(route('albums.store', ['token' => $token]), [
            'name' => 'Favorite Album',
            'artist_name' => 'Favorite Artist',
            'user_id' => $user->id,
        ]);

        $response->assertStatus(201);

        $albumId = $response->json('data.id');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->get(route('albums.show', ['album' => $albumId]));

        $response->assertSuccessful();

    }

    /**
     * A user can update a favorite album.
     */
    public function testUserCanUpdateCurrentFavoriteAlbum()
    {
        $user = User::factory()->create();
        $token = $this->loginUser($user);

        $this->assertNotNull($token);
        $album = UserFavouriteAlbum::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson(route('albums.update', ['album' => $album->id]), [
                'name' => 'Flower Of Devotion',
                'artist_name' => 'Dehd',
                'user_id' => $user->id,
            ]);

        $response->assertStatus(200);
    }

    /**
     * A user can delete a favorite album.
     */
    public function testUserCanDeleteCurrentFavoriteAlbum()
    {
        $user = User::factory()->create();
        $token = $this->loginUser($user);

        $this->assertNotNull($token);

        $album = UserFavouriteAlbum::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                          ->delete(route('albums.destroy', ['album' => $album->id]));

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
