<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompartimentTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test3()
    {
        $my_api_token = 'zdaODxJwie7VXF20i4NZ'; ## set your api token
        $response = $this->get('api/compartiment?api_token=' . $my_api_token
        // , ['api_token' => $my_api_token]
        );
        $response->assertStatus(201);

        // $response = $this->get('api/compartiment/1', [
        //     'api_token' => $my_api_token
        // ]);
        // $response->assertStatus(201);

        // $response = $this->put('api/compartiment/1', [
        //     'api_token' => $my_api_token,
        //     'cap_temp' => 30
        // ]);
        // $response->assertStatus(201);
    }
}
