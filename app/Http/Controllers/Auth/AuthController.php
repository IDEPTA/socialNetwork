<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginValidation;
use App\Http\Requests\Auth\RegisterValidation;
use App\Interfaces\Auth\AuthServicesInterface;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(protected AuthServicesInterface $authService) {}

    public function login(LoginValidation $loginData)
    {
        try {
            $token = $this->authService->login($loginData);

            return response()->json([
                "token" => $token
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function register(RegisterValidation $registerData)
    {
        try {
            $token = $this->authService->register($registerData);

            return response()->json([
                "msg" => "Регистрация прошла успешно",
                "token" => $token
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function logout(Request $req)
    {
        try {
            $this->authService->logout($req);

            return response()->json([
                "msg" => "вы разлогинились,токен удален"
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }
}
