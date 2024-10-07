<?php

namespace App\Http\Controllers\Chat;

use Exception;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatValidation;
use App\Interfaces\Chat\ChatServiceInterface;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(private ChatServiceInterface $chatService) {}

    public function index(): JsonResponse
    {
        try {
            $result = $this->chatService->index();

            return response()->json([
                "chats" => $result
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChatValidation $request): JsonResponse
    {
        try {
            $newChat = $this->chatService->store($request);

            return response()->json([
                "chat" => $newChat
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat): JsonResponse
    {
        try {
            $result = $this->chatService->show($chat);

            return response()->json([
                "chat" => $result
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChatValidation $request, Chat $chat): JsonResponse
    {
        try {
            $updatedChat = $this->chatService->update($request, $chat);

            return response()->json([
                "chat" => $updatedChat
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat): JsonResponse
    {
        try {
            $this->chatService->destroy($chat);

            return response()->json([
                "msg" => "Чат удален"
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }
}
