<?php

namespace App\Interfaces\Telegram;

use App\Models\User;


interface TelegramServiceInterface
{
    public function getUserUrl(): string;
    public function setWebhook(string $url): object;
    public function sendTfaCode(User $user);
    public function sendResetPassword(int $chat_id, string $newPassword);
}