<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BacTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test2()
    {
        $my_api_token = 'zdaODxJwie7VXF20i4NZ'; ## set your api token
        $response = $this->get('api/bac?api_token=' . $my_api_token);
        $response->assertStatus(201);

        // $response = $this->post('api/bac', [
        //     'api_token' => $my_api_token,
        //     'name' => 'bac-de-test'
        // ]);
        // $response->assertStatus(201);

        // $response = $this->post('api/bac/1', [
        //     'api_token' => $my_api_token
        // ]);
        // $response->assertStatus(201);

        // $response = $this->delete('api/bac/1', [
        //     'api_token' => $my_api_token
        // ]);
        // $response->assertStatus(201);
    }
}
