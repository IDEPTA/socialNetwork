<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class CommentsTest extends TestCase
{

    public function test_store_comment_request(): void
    {
        $newComment = [
            'post_id' => 1,
            'text' => 'New Comment TEST',
            'user_id' => 1
        ];
        $response = $this->post('/api/comments', $newComment);

        Log::channel("testing_results_request")
            ->info("STORE", ['data' => $response['newComment']]);

        $response->assertCreated();
        $this->assertDatabaseHas('comments', $newComment);
    }

    public function test_index_comment_request()
    {
        $response = $this->get('/api/comments');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_show_comment_request()
    {
        $comment = Comment::OrderBy('id', 'desc')->first();
        $response = $this->get("/api/comments/{$comment->id}");
        Log::channel("testing_results_request")
            ->info("SHOW", [
                'id' => $comment->id,
                'data' => $response['comment']
            ]);

        $response->assertStatus(200);
    }

    public function test_update_comment_request()
    {
        $comment = Comment::OrderBy('id', 'desc')->first();
        $updatedData = [
            'post_id' => 1,
            'text' => 'Updated Comment TEST',
            'user_id' => 1
        ];

        $response = $this->put("/api/comments/{$comment->id}", $updatedData);

        Log::channel("testing_results_request")
            ->info("UPDATED", ['data' => $response['comments']]);

        $response->assertOk();
        $this->assertDatabaseHas('comments', $updatedData);
    }

    public function test_delete_comment_request()
    {
        $comment = Comment::OrderBy('id', 'desc')->first();
        $response = $this->delete("/api/comments/{$comment->id}");

        Log::channel("testing_results_request")
            ->info("DELETED", [
                'id' => $comment->id,
                'data' => $response['msg']
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}