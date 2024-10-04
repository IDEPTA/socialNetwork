<?php

namespace App\Http\Controllers\Message;

use Exception;
use App\Models\Chat;
use App\Http\Controllers\Controller;
use App\Interfaces\MessageRepository\MessageRepositoryInterface;

class MessageShowController extends Controller
{
    public function __construct(private MessageRepositoryInterface $messageRepository) {}

    public function getMessageForChat(Chat $chat)
    {
        try {
            $messages = $this->messageRepository->getMessageForChat($chat);

            return response()->json([
                "messages" => $messages
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }
}
