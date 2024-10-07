<?php

namespace App\Repositories\Chat;

use App\Interfaces\ChatRepository\ChatRepositoryInterface;
use App\Models\Chat;
use App\Models\User;

class ChatRepository implements ChatRepositoryInterface
{
    public function getChatsForUser(User $user): object
    {
        $chats = Chat::with(['sender'])
            ->where("senderId", $user->id)
            ->get();

        return $chats;
    }
}
