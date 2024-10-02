<?php

namespace App\Services\Chat;

use App\Models\Chat;
use App\Http\Requests\ChatValidation;
use App\Interfaces\Chat\ChatServiceInterface;

class ChatService implements ChatServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index(): object
    {
        $chats = Chat::with(['sender', 'recipient'])->get();

        return $chats;
    }

    public function show(Chat $chat): Chat
    {
        return $chat;
    }

    public function store(ChatValidation $req): Chat
    {
        $validationData = $req->validated();
        $newChat = Chat::create($validationData);

        return $newChat;
    }

    public function update(ChatValidation $req, Chat $chat): Chat
    {
        $validationData = $req->validated();
        $chat->update($validationData);

        return $chat;
    }

    public function destroy(Chat $chat): void
    {
        $chat->delete();
    }
}
