<?php

namespace App\Services\Message;

use App\Models\Message;
use App\Events\MessageSent;
use App\Http\Requests\MessageValidation;
use App\Interfaces\Message\MessageServiceInterface;

class MessageService implements MessageServiceInterface
{

    public function index(): object
    {
        $messages = Message::with(["user", "chat"])->get();

        return $messages;
    }

    public function store(MessageValidation $req): Message
    {
        $validationData = $req->validated();
        $newMessage = Message::create($validationData);

        broadcast(new MessageSent($newMessage))->toOthers();

        return $newMessage;
    }

    public function show(Message $message): Message
    {
        return $message;
    }

    public function update(MessageValidation $req, Message $message): Message
    {
        $validationData = $req->validated();
        $message->update($validationData);

        return $message;
    }

    public function destroy(Message $message): void
    {
        $message->delete();
    }
}
