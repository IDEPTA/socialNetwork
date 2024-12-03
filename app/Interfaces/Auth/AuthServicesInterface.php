<?php

namespace App\Interfaces\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginValidation;
use App\Http\Requests\Auth\RegisterValidation;
use App\Http\Requests\Auth\ResetPasswordValidation;

interface AuthServicesInterface
{
    public function login(LoginValidation $loginData);
    public function sendCodeConfirm(User $user);
    public function register(RegisterValidation $registerData);
    public function logout(Request $token);
    public function resetPassword(ResetPasswordValidation $resetData);
}