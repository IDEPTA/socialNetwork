<?php

namespace App\Interfaces\MessageRepository;

use App\Models\Chat;

interface MessageRepositoryInterface
{
    public function getMessageForChat(Chat $chat): object;
}
