<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTokenTest extends TestCase
{
    public function test_apiToken() {
        $response = $this->getJson('/api/user', [
            'api_token' => "cG1K8uKxQsiMrg3J1aNT"
        ]);

        $response->assertStatus(202);
    }

    public function test_bad_apiToken() {
        $response = $this->getJson('/api/user', [
            'api_token' => "falseapitoken"
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'state' => 'Invalid api_token'
            ]);
    }

    public function test_bacToken() {
        $response = $this->getJson('/api/compartiment', [
            'bac_token' => "he6vYptB6V9cWqf9mVD7"
        ]);

        $response->assertStatus(200);
    }
}
