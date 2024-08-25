<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginValidation;
use App\Http\Requests\Auth\RegisterValidation;
use App\Interfaces\Auth\AuthServicesInterface;
use App\Http\Requests\Auth\ResetPasswordValidation;
use Illuminate\Http\Request;

class AuthServices implements AuthServicesInterface
{
    public function login(LoginValidation $loginData)
    {
        $validationData = $loginData->validated();
        $user = User::where("email", $validationData['login'])->first();

        if ($user && Hash::check($validationData['password'], $user->password)) {
            $token = $user->createToken("auth_token")->plainTextToken;

            return $token;
        }
    }

    public function register(RegisterValidation $registerData)
    {
        $validationData = $registerData->validated();
        $newUser = User::create($validationData);
        $token = $newUser->createToken("auth_token")->plainTextToken;

        return $token;
    }

    public function logout(Request $token)
    {
        $token->user()->currentAccessToken()->delete();

        return true;
    }

    public function resetPassword(ResetPasswordValidation $resetData) {}
}
