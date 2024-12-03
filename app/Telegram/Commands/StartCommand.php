<?php

namespace App\Telegram\Commands;

use Orchid\Platform\Models\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class StartCommand extends Command
{
    protected string $name = 'start'; // Имя команды
    protected string $description = 'Команда старт для вашего бота'; // Описание команды

    public function handle()
    {
        // Ответ на команду /start
        $updates = Telegram::getWebhookUpdate();
        $chatId = $updates['message']['chat']['id'];
        $userName = $updates['message']['from']['username'];

        $id = explode(' ', $updates['message']['text']);

        if (count($id) < 2) {
            $this->replyWithMessage([
                'text' => 'Не удалось привязать аккаунт аккаунт, попробуйте перейти по ранее полученной ссылке'
            ]);

            return true;
        }

        $user = User::findOrFail($id[1]);

        if ($user->telegram_chat_id == null) {
            $user->telegram_chat_id = $chatId;
            $user->tfa = true;
            $user->telegram_username = $userName;
            $user->save();
        }


        $this->replyWithMessage([
            'text' => "Привет, это бот пет-проекта socialNetwork, я нужен для двух факторной аутентификации!"
        ]);
    }
}