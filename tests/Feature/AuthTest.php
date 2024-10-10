<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{

    public function test_register()
    {
        $registerData = [
            "name" => "TestUser",
            "email" => "test@test.com",
            "password" => Hash::make(123123123),
            "password_confirmation" => 123123123
        ];

        $response = $this->post("/api/register", $registerData);
        Log::channel("testing_results_request")
            ->info("User register", [
                'msg' => $response['msg'],
                'token' => $response['token'],
            ]);

        $response->assertCreated()->assertJson([
            "msg" => "Регистрация прошла успешно",
            "token" => $response['token']
        ]);

        $this->assertDatabaseHas("users", [
            "name" => "TestUser",
            "email" => "test@test.com",
        ]);
    }

    public function test_login()
    {
        $loginData = [
            "login" => 'test@test.com',
            "password" => 123123123
        ];

        $response = $this->post("/api/login", $loginData);
        Log::channel("testing_results_request")
            ->info("User login", [
                'token' => $response['token'],
            ]);

        $response->assertOk()->assertJson([
            "token" => $response['token']
        ]);
    }

    public function test_logout()
    {
        $user = User::orderBy("id", "desc")->first();

        $loginData = [
            "login" => 'test@test.com',
            "password" => 123123123
        ];

        $loginResponse = $this->postJson('/api/login', $loginData);

        // Убедимся, что логин прошел успешно и в ответе есть токен
        $loginResponse->assertOk();
        $token = $loginResponse['token'];

        $logoutResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/logout');

        Log::channel("testing_results_request")
            ->error("User logout", [
                'token' => $token,
                'user' => $user->id
            ]);

        $logoutResponse->assertOk()->assertJson([
            'msg' => 'вы разлогинились,токен удален',
        ]);

        $user->delete();
    }
}