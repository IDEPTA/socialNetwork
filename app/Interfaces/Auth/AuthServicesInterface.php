<?php

namespace App\Interfaces\Auth;

use App\Http\Requests\Auth\LoginValidation;
use App\Http\Requests\Auth\RegisterValidation;
use App\Http\Requests\Auth\ResetPasswordValidation;
use Illuminate\Http\Request;

interface AuthServicesInterface
{
    public function login(LoginValidation $loginData);
    public function register(RegisterValidation $registerData);
    public function logout(Request $token);
    public function resetPassword(ResetPasswordValidation $resetData);
}
