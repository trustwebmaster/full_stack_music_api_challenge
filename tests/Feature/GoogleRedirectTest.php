<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GoogleRedirectTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUserCanSignInWithGoogle(): void
    {
        $response = $this->get(route('google.redirect'));

        $response->assertStatus(200);
    }
}
