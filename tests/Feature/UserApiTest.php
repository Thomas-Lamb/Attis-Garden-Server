<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{

    public $apiToken = "3|hI3DCIbXsNHMXvl4M31dWspbw8wn6eG2w8ydZen3";
    public $userMail = "unitest@test.com";
    public $userPwd = "password";
    public $userUsername = "unitest";
    public $userFirstname = "uni";
    public $userLastname = "test";
    public $userPhone = "1111111111";
    public $userId = 4;

    public function init() {
        $this->userMail = fake()->email();
        $this->userPwd = "password";
        $this->userUsername = fake()->name();
        $this->userFirstname = fake()->name();
        $this->userLastname = fake()->name();
        $this->userPhone = fake()->phoneNumber();
    }

    public function createUser() {
        $this->init();
        $response = $this->postJson('/api/user/register', [
            'username' => $this->userUsername,
            'first_name' => $this->userFirstname,
            'last_name' => $this->userLastname,
            'phone' => $this->userPhone,
            'password' => $this->userPwd,
            'email' => $this->userMail
        ]);
        $response = $this->getJson('/api/user/login', [
            'email' => $this->userMail,
            'password' => $this->userPwd
        ]);
        $this->apiToken = $response["data"]["api_token"];
    }

    public function test_register() {
        $this->init();
        $response = $this->postJson('/api/user/register', [
            'username' => $this->userUsername,
            'first_name' => $this->userFirstname,
            'last_name' => $this->userLastname,
            'phone' => $this->userPhone,
            'email' => $this->userMail,
            'password' => $this->userPwd
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => "User registered",
            ]);
    }

    public function test_register_with_email_allready_used() {
        $response = $this->postJson('/api/user/register', [
            'username' => $this->userUsername,
            'first_name' => $this->userFirstname,
            'last_name' => $this->userLastname,
            'phone' => fake()->phoneNumber(),
            'email' => $this->userMail,
            'password' => $this->userPwd
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => "The email has already been taken."
            ]);
    }

   public function test_login() {
       $response = $this->getJson('/api/user/login', [
           'email' => $this->userMail,
           'password' => $this->userPwd
       ]);

       $response
           ->assertStatus(200)
           ->assertJson([
            "data" => [
                'api_token' => $this->apiToken
            ]
           ]);
   }

   public function test_login_with_bad_password() {
    $response = $this->getJson('/api/user/login', [
        'email' => $this->userMail,
        'password' => "badpassword"
    ]);

    $response
        ->assertStatus(400)
        ->assertJson([
            'message' => "Incorrect credentials"
        ]);
}

    public function test_apiToken_login() {
        $data = [
        ];
        $header = [
            "Authorization" => "Bearer " . $this->apiToken,
            "Accept" => "application/json"
        ];
        $response = $this->getJson('/api/user', $data, $header);

        $response
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    'username' => $this->userUsername,
                ]
            ]);
    }

    public function test_update_email() {
        $data = [
            'email' => "test_changed@test.com"
        ];
        $header = [
            "Authorization" => "Bearer " . $this->apiToken,
            "Accept" => "application/json"
        ];
        $response = $this->putJson('/api/user/email', $data, $header);

        $data = [
            'email' => $this->userMail
        ];
        $response = $this->putJson('/api/user/email', $data, $header);

        $response
            ->assertStatus(202)
            ->assertJson([
                "message" => "Email updated"
            ]);
    }

    public function test_update_with_email_allready_used() {
        $data = [
            'email' => "testallreadyused@test.com"
        ];
        $header = [
            "Authorization" => "Bearer " . $this->apiToken,
            "Accept" => "application/json"
        ];
        $response = $this->putJson('/api/user/email', $data, $header);

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The email has already been taken."
            ]);
    }

    public function test_delete_user() {
        $this->createUser();

        $data = [
        ];
        $header = [
            "Authorization" => "Bearer " . $this->apiToken,
            "Accept" => "application/json"
        ];
        $response = $this->deleteJson('/api/user', $data, $header);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'User deleted'
            ]);
    }

    // public function test_delete_user_with_bad_token() {
    //     $this->createUser();

    //     $response = $this->deleteJson('/api/user', [
    //         'api_token' => "badtoken"
    //     ]);

    //     $response
    //          ->assertStatus(400)
    //         ->assertJson([
    //             "state" => "Invalid api_token"
    //         ]);
    // }

    public function test_change_password() {
        $data = [
            'current_password' => "password",
            'password' => "password"
        ];
        $header = [
            "Authorization" => "Bearer " . $this->apiToken,
            "Accept" => "application/json"
        ];
        $response = $this->putJson('/api/user/pwd', $data, $header);

        $response
            ->assertStatus(202)
            ->assertJson([
                'message' => 'Password updated'
            ]);
    }

    public function test_change_password_with_bad_password() {

        $data = [
            'current_password' => "badpassword",
            'password' => "password"
        ];
        $header = [
            "Authorization" => "Bearer " . $this->apiToken,
            "Accept" => "application/json"
        ];
        $response = $this->putJson('/api/user/pwd', $data, $header);

        $response
            ->assertStatus(400)
            ->assertJson([
                'message' => 'Bad current password'
            ]);
    }
}
