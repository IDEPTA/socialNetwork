<?php

namespace App\Http\Controllers;

use App\Services\Telegram\TelegramService;
use Telegram\Bot\Api;
use Illuminate\Http\Request;


class BotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  Api  $telegram
     */
    public function __construct(
        protected Api $telegram,
        protected TelegramService $telegramService
    ) {}

    public function webhook()
    {
        $this->telegram->commandsHandler(true);
        return response("Сообщение бота отправлено", 200);
    }

    /**
     * Show the bot information.
     */
    public function show()
    {
        $response = $this->telegram->getMe();

        return $response;
    }

    public function getUserUrl()
    {
        try {
            $url = $this->telegramService->getUserUrl();
            return response()->json([
                "ulr" => $url
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function setWebhook(Request $req)
    {
        try {
            $validated = $req->validate([
                "url" => "required|url",
            ]);
            $webhookInfo = $this->telegramService->setWebhook($validated['url']);
            return response()->json([
                "webhookInfo" => $webhookInfo
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }
}