<?php

namespace App\Http\Controllers\Message;

use Exception;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageValidation;
use App\Interfaces\Message\MessageServiceInterface;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private MessageServiceInterface $messageService) {}

    public function index(): JsonResponse
    {
        try {
            $result = $this->messageService->index();

            return response()->json([
                "messages" => $result
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
    public function store(MessageValidation $request): JsonResponse
    {
        try {
            $newMessage = $this->messageService->store($request);

            return response()->json([
                "message" => $newMessage
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
    public function show(Message $message): JsonResponse
    {
        try {
            $message = $this->messageService->show($message);

            return response()->json([
                "message" => $message
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
    public function update(MessageValidation $request, Message $message): JsonResponse
    {
        try {
            $updatedMessage = $this->messageService->update($request, $message);

            return response()->json([
                "message" => $updatedMessage
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
    public function destroy(Message $message): JsonResponse
    {
        try {
            $this->messageService->destroy($message);

            return response()->json([
                "msg" => "Сообщение удалено"
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }
}
