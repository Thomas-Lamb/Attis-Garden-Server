<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTokenTest extends TestCase
{
    public function test_apiToken() {
        $data = [
        ];
        $header = [
            "Authorization" => "Bearer hI3DCIbXsNHMXvl4M31dWspbw8wn6eG2w8ydZen3",
            "Accept" => "application/json"
        ];
        $response = $this->getJson('/api/user', $data, $header);

        $response->assertStatus(200);
    }

    public function test_bad_apiToken() {
        $data = [
        ];
        $header = [
            "Authorization" => "Bearer falseapitoken",
            "Accept" => "application/json"
        ];
        $response = $this->getJson('/api/user', $data, $header);

        $response
            ->assertStatus(401)
            ->assertJson([
                "message" => "Unauthenticated."
            ]);
    }

    public function test_bacToken() {
        $data = [
            "bac_token" => "wiNFSSfkbDfQgTWVlLje"
        ];
        $header = [
            "Accept" => "application/json"
        ];
        $response = $this->getJson('/api/compartiment', $data, $header);

        $response->assertStatus(200);
    }

    public function test_bad_bacToken() {
        $data = [
            "bac_token" => "falsebactoken"
        ];
        $header = [
            "Accept" => "application/json"
        ];
        $response = $this->getJson('/api/compartiment', $data, $header);

        $response->assertStatus(400);
    }
}
