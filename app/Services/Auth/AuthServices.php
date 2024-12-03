<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Jobs\sendEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendTfaCodeToTelegramJob;
use App\Http\Requests\Auth\LoginValidation;
use App\Http\Requests\Auth\RegisterValidation;
use App\Interfaces\Auth\AuthServicesInterface;
use App\Http\Requests\Auth\ResetPasswordValidation;

class AuthServices implements AuthServicesInterface
{
    public function login(LoginValidation $loginData)
    {
        $validationData = $loginData->validated();
        $user = User::where("email", $validationData['login'])->first();

        if ($user->tfa) {
            $this->sendCodeConfirm($user);
        }
        if ($user && Hash::check($validationData['password'], $user->password)) {
            $token = $user->createToken("auth_token")->plainTextToken;

            return $token;
        }
    }

    public function sendCodeConfirm(User $user)
    {
        SendTfaCodeToTelegramJob::dispatchSync($user);
    }

    public function register(RegisterValidation $registerData)
    {
        $validationData = $registerData->validated();
        $newUser = User::create($validationData);
        $token = $newUser->createToken("auth_token")->plainTextToken;
        sendEmailJob::dispatch($newUser);

        return $token;
    }

    public function logout(Request $token)
    {
        $token->user()->currentAccessToken()->delete();

        return true;
    }

    public function resetPassword(ResetPasswordValidation $resetData)
    {
        $validationData = $resetData->validated();
    }
}