<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\sendEmailNotification;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\emailNotificationRequest;
use App\Jobs\SendLogJob;

class EmailNotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(emailNotificationRequest $request)
    {
        $messageData = $request->validated();

        $users = User::whereNotNull("email_verified_at")->where("id", $messageData['user_id'])->get();

        Log::info('отправлено этим пользователям:', ['users' => $users]);
        sendEmailNotification::dispatch($users, $messageData['title'], $messageData['text']);
        SendLogJob::dispatch('Отправка email рассылки', 'info');
        return response()->json(['msg' => "Сообщение отправлено для " . count($users) . " пользователей"]);
    }
}
