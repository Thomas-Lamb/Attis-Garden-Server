<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{

    public $apiToken = "S454b7LnajSrXt39Dlcj";
    public $userMail = "test@test.com";
    public $userPwd = "testpwd";
    public $userName = "test";
    public $userId = 214;
    
    public function init() {
        $this->userMail = fake()->email();
        $this->userPwd = "mdptest";
        $this->userName = fake()->name();
    }

    public function createUser() {
        $this->init();
        $response = $this->postJson('/api/user/register', [
            'name' => $this->userName,
            'password' => $this->userPwd,
            'email' => $this->userMail
        ]);
        $response = $this->getJson('/api/user/login', [
            'email' => $this->userMail,
            'password' => $this->userPwd
        ]);
        $this->apiToken = $response["data"]["api_token"];
        $this->userId = $response["data"]["id"];
    }

    public function test_register() {
        $this->init();
        $response = $this->postJson('/api/user/register', [
            'name' => $this->userName,
            'password' => $this->userPwd,
            'email' => $this->userMail
        ]);
        
        $response
            ->assertStatus(201)
            ->assertJson([
                'state' => "OK",
            ]);
    }

    public function test_register_with_email_allready_used() {
        $response = $this->postJson('/api/user/register', [
            'name' => $this->userName,
            'password' => $this->userPwd,
            'email' => $this->userMail
        ]);
        
        $response
            ->assertStatus(400)
            ->assertJson([
                'state' => "Email allready used"
            ]);
    }

   public function test_login() {
       $response = $this->getJson('/api/user/login', [
           'email' => $this->userMail,
           'password' => $this->userPwd
       ]);
    //    $this->apiToken = $response["api_token"];
       $response
           ->assertStatus(200)
           ->assertJson([
            "data" => [
                'name' => $this->userName
            ],
            "state" => "OK"
           ]);
   }

   public function test_login_with_bad_password() {
    $response = $this->getJson('/api/user/login', [
        'name' => $this->userName,
        'password' => "badpassword"
    ]);
 //    $this->apiToken = $response["api_token"];
    $response
        ->assertStatus(400)
        ->assertJson([
            'state' => "Bad username or password"
        ]);
}

    public function test_apiToken_login() {
        $response = $this->getJson('/api/user', [
            'api_token' => $this->apiToken
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    'name' => $this->userName,
                    'api_token' => $this->apiToken
                ],
                "state" => "OK"
            ]);
    }

    public function test_update_email() {
        $response = $this->putJson('/api/user/email', [
            'api_token' => $this->apiToken,
            'email' => "test_changed@test.com"
        ]);

        $response = $this->putJson('/api/user/email', [
            'api_token' => $this->apiToken,
            'email' => $this->userMail
        ]);

        $response->assertStatus(202);
    }

    public function test_update_with_email_allready_used() {
        $response = $this->putJson('/api/user/email', [
            'api_token' => $this->apiToken,
            'email' => "testallreadyused@test.com"
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                "state" => "Email allready used"
            ]);
    }

    public function test_delete_user() {
        $this->createUser();

        $response = $this->deleteJson('/api/user', [
            'api_token' => $this->apiToken
        ]);

        $response
            ->assertStatus(202)
            ->assertJson([
                "state" => "OK"
            ]);
    }

    public function test_delete_user_with_bad_token() {
        $this->createUser();

        $response = $this->deleteJson('/api/user', [
            'api_token' => "badtoken"
        ]);

        $response
             ->assertStatus(400)
            ->assertJson([
                "state" => "Invalid api_token"
            ]);
    }

    public function test_change_password() {

        $response = $this->putJson('/api/user/pwd', [
            'api_token' => $this->apiToken,
            'current_password' => $this->userPwd,
            'password' => "testpwd_change"
        ]);

        $response = $this->putJson('/api/user/pwd', [
            'api_token' => $this->apiToken,
            'current_password' => "testpwd_change",
            'password' => $this->userPwd
        ]);

        $response
            ->assertStatus(202)
            ->assertJson([
                'state' => 'OK'
            ]);
    }

    public function test_change_password_with_bad_password() {

        $response = $this->putJson('/api/user/pwd', [
            'api_token' => $this->apiToken,
            'current_password' => "badpassword",
            'password' => "testpwd_change"
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'state' => 'Bad api token or password'
            ]);
    }
}
