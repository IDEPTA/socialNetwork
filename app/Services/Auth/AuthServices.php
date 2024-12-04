<?php

namespace App\Services\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Jobs\sendEmailJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendTfaCodeToTelegramJob;
use App\Http\Requests\Auth\LoginValidation;
use App\Http\Requests\Auth\RegisterValidation;
use App\Interfaces\Auth\AuthServicesInterface;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Jobs\SendNewPasswordToTelegramJob;

class AuthServices implements AuthServicesInterface
{
    public function login(LoginValidation $loginData)
    {
        $validationData = $loginData->validated();
        $user = User::where("email", $validationData['login'])->first();

        if ($user && Hash::check($validationData['password'], $user->password)) {
            if ($user->tfa) {
                $this->sendCodeConfirm($user);
                return "код отправлен в телеграмм. Срок действия 15 минут";
            }
            $token = $user->createToken("auth_token")->plainTextToken;

            return $token;
        }

        throw new Exception("Неверный пароль", 401);
    }

    public function sendCodeConfirm(User $user)
    {
        SendTfaCodeToTelegramJob::dispatch($user);
    }

    public function confirmTfaCode(string $code)
    {
        $user = User::where("tfa_code", $code)->first();
        if (!$user || Carbon::now() > $user->tfa_code_expries_at) {
            return "Код не действителен, попробуй снова";
        }
        $token = $user->createToken("auth_token")->plainTextToken;
        $user->tfa_code = null;
        $user->tfa_code_expries_at = null;
        $user->save();
        return $token;
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

    public function resetPassword(PasswordResetRequest $resetData)
    {
        $validationData = $resetData->validated();
        $user = User::where("email", $validationData["email"])->first();
        if (!$user) {
            throw new Exception("Пользователь с таки email не найден", 404);
        } elseif (!$user->tfa) {
            throw new Exception("Для сброса пароля необходимо подключить телеграм", 404);
        } else {
            $newPassword = substr(Str::random(25), 0, 20);
            $user->password = Hash::make($newPassword);
            $user->save();
            SendNewPasswordToTelegramJob::dispatch((int)$user->telegram_chat_id, $newPassword);
            return "Новый пароль отправлен в телеграм";
        }
    }
}