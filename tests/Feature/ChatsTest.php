<?php

namespace Tests\Feature;

use App\Models\Chat;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class ChatsTest extends TestCase
{
    public function test_store_chat_request()
    {
        $newChat = [
            "senderId" => 1,
            "recipientId" => 2
        ];
        $response = $this->post("/api/chats", $newChat);

        Log::channel("testing_results_request")
            ->info("STORE Chat", ['data' => $response['chat']]);

        $response->assertCreated();
        $this->assertDatabaseHas("chats", $newChat);
    }

    public function test_index_chat_request()
    {
        $response = $this->get("/api/chats");

        $response->assertStatus(200);
        $response->assertHeader("Content-type", "application/json");
    }

    public function test_show_chat_request()
    {
        $chat = Chat::orderBy("id", "desc")->first();
        $response = $this->get("/api/chats/{$chat->id}");

        Log::channel("testing_results_request")
            ->info("SHOW Chat", [
                'id' => $chat->id,
                'data' => $response['chat']
            ]);
        $response->assertStatus(200);
    }

    public function test_update_chat_request()
    {
        $chat = Chat::orderBy("id", "desc")->first();
        $updatedChat = [
            "senderId" => 1,
            "recipientId" => 3
        ];

        $response = $this->put("/api/chats/{$chat->id}", $updatedChat);
        Log::channel("testing_results_request")
            ->info("UPDATED Chat", ['data' => $response['chat']]);

        $response->assertOk();
        $this->assertDatabaseHas("chats", $updatedChat);
    }

    public function test_delete_chat_request()
    {
        $chat = Chat::orderBy("id", "desc")->first();
        $response = $this->delete("/api/chats/{$chat->id}");

        Log::channel("testing_results_request")
            ->info("DELETED Chat", [
                'id' => $chat->id,
                'data' => $response['msg']
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing("chats", ['id' => $chat->id]);
    }
}