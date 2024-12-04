<?php

namespace App\Services\Telegram;

use Illuminate\Support\Str;
use Orchid\Platform\Models\User;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Interfaces\Post\PostServiceInterface;
use App\Interfaces\Telegram\TelegramServiceInterface;
use Carbon\Carbon;

class TelegramService implements TelegramServiceInterface
{
    public function getUserUrl(): string
    {
        $user = Auth::user();
        $userId = $user->id;
        $botUrl = config('app.telegram_url');
        $botUrl .= "?start=" . $userId;
        return $botUrl;
    }

    public function setWebhook(string $url): object
    {
        Telegram::setWebhook(['url' => $url]);
        $webhookInfo = Telegram::getWebhookInfo();
        return $webhookInfo;
    }

    public function sendTfaCode(User $user)
    {
        $code = substr(Str::random(10), 0, 10);
        Telegram::sendMessage([
            "chat_id" => $user->telegram_chat_id,
            "text" => "Ваш код подтверждения: `$code`",
            "parse_mode" => "MarkdownV2"
        ]);
        $user->tfa_code = $code;
        $user->tfa_code_expries_at = Carbon::now()->addHour(3)->addMinute(15);
        $user->save();
    }

    public function sendResetPassword(int $chat_id, string $newPassword)
    {
        Telegram::sendMessage([
            "chat_id" => $chat_id,
            "text" => "Твой новый пароль `$newPassword`",
            "parse_mode" => "MarkdownV2"
        ]);
    }
}