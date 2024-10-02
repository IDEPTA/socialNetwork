<?php

namespace App\Interfaces\Chat;

use App\Http\Requests\ChatValidation;
use App\Models\Chat;

interface ChatServiceInterface
{
    public function index(): object;
    public function show(Chat $chat): Chat;
    public function store(ChatValidation $req): Chat;
    public function update(ChatValidation $req, Chat $chat): Chat;
    public function destroy(Chat $chat): void;
}