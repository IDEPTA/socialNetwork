<?php

namespace App\Http\Controllers\Chat;

use Exception;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Interfaces\ChatRepository\ChatRepositoryInterface;

class ChatShowController extends Controller
{
    public function __construct(private ChatRepositoryInterface $chatRepository) {}

    public function getChatsForUser(User $user)
    {
        try {
            $chats = $this->chatRepository->getChatsForUser($user);

            return response()->json([
                "chats" => $chats
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }
}
