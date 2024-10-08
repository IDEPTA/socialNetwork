<?php

namespace App\Http\Controllers;

use App\Http\Requests\emailNotificationRequest;
use App\Jobs\sendEmailNotification;
use App\Models\User;
use Illuminate\Http\Request;

class EmailNotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(emailNotificationRequest $request)
    {
        $messageData = $request->validated();

        $users = User::where("email_verified_at")->get();

        sendEmailNotification::dispatch($users, $messageData['title'], $messageData['text']);

        return response()->json(['msg' => "Сообщение отправлено для " . count($users) . " пользователей"]);
    }
}
