<?php

namespace App\Repositories\Message;

use App\Models\Chat;
use App\Models\Message;
use App\Interfaces\MessageRepository\MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    public function getMessageForChat(Chat $chat): object
    {
        $messages = Message::with(["user", "chat"])
            ->where("chat_id", $chat->id)
            ->get();

        return $messages;
    }
}
