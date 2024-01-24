<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class MusicApiConnectionTest extends TestCase
{

    use RefreshDatabase;

    private function callLastFmEndpoint(string $routeName, array $parameters = []): TestResponse
    {
        return $this->postJson(route($routeName, $parameters));
    }

    public function testSearchForAlbum(): void
    {
        $response = $this->callLastFmEndpoint( 'albums', ['query' => 'divide']);

        $response->assertStatus(200);

    }

    public function testSearchForArtist(): void
    {
        $response = $this->callLastFmEndpoint('artists', ['name' => 'Dolly Parton']);

        $response->assertStatus(200);

    }

    public function testViewArtist(): void
    {
        $response = $this->callLastFmEndpoint('artist.view', ['name' => 'Dolly Parton']);

        $response->assertStatus(200);

    }

    public function testViewAlbum(): void
    {
        $response = $this->callLastFmEndpoint('album.view', ['album' => 'Cherry Bomb' , 'artist' => 'Tyler, the Creator']);

        $response->assertStatus(200);

    }

}
