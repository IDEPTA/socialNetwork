<?php

namespace App\Interfaces\Message;

use App\Http\Requests\MessageValidation;
use App\Models\Message;

interface MessageServiceInterface
{
    public function index(): Object;
    public function show(Message $message): Message;
    public function store(MessageValidation $req): Message;
    public function update(MessageValidation $req, Message $message): Message;
    public function destroy(Message $message): void;
}
