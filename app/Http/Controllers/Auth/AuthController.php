<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmCodeRequest;
use App\Http\Requests\Auth\LoginValidation;
use App\Http\Requests\Auth\RegisterValidation;
use App\Interfaces\Auth\AuthServicesInterface;
use App\Http\Requests\Auth\PasswordResetRequest;

class AuthController extends Controller
{

    public function __construct(protected AuthServicesInterface $authService) {}

    public function login(LoginValidation $loginData): JsonResponse
    {
        try {
            $token = $this->authService->login($loginData);

            return response()->json([
                "token" => $token
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function code_confirm(ConfirmCodeRequest $request): JsonResponse
    {
        try {
            $validate = $request->validated();
            $token = $this->authService->confirmTfaCode($validate['code']);
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

    public function register(RegisterValidation $registerData): JsonResponse
    {
        try {
            $token = $this->authService->register($registerData);

            return response()->json([
                "msg" => "Регистрация прошла успешно",
                "token" => $token
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function logout(Request $req): JsonResponse
    {
        try {
            $this->authService->logout($req);

            return response()->json([
                "msg" => "вы разлогинились,токен удален"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function reset_password(PasswordResetRequest $request)
    {
        try {
            $newPassword = $this->authService->resetPassword($request);
            return response()->json([
                "password" => $newPassword
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ], $e->getCode());
        }
    }
}