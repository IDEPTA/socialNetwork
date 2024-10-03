<?php

namespace App\Interfaces\ChatRepository;

use App\Models\User;

interface ChatRepositoryInterface
{
    public function getChatsForUser(User $user): object;
}
