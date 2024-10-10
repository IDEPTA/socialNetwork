<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsTest extends TestCase
{

    protected Comment $createdComment;

    protected function setUp(): void
    {
        parent::setUp();


        // Создаем комментарий, который будет использоваться в тестах
        $this->createdComment = Comment::create([
            'post_id' => 1,
            'text' => 'New Comment TEST',
            'user_id' => 1,
        ]);
    }

    public function test_store_comment_request(): void
    {
        $comment = [
            'post_id' => 1,
            'text' => 'New Comment TEST',
            'user_id' => 1
        ];

        $response = $this->post('/api/comments', $comment);

        $response->assertCreated();
        $this->assertDatabaseHas('comments', $comment);
    }

    public function test_index_comment_request()
    {
        $response = $this->get('/api/comments');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_show_comment_request()
    {
        $response = $this->get("/api/comments/{$this->createdComment->id}");

        $response->assertStatus(200);
    }

    public function test_update_comment_request()
    {
        $updatedData = [
            'post_id' => $this->createdComment->post_id, // Используем post_id из созданного комментария
            'text' => 'Updated Comment TEST',
            'user_id' => $this->createdComment->user_id // Используем user_id из созданного комментария
        ];

        $response = $this->put("/api/comments/{$this->createdComment->id}", $updatedData);

        $response->assertOk();
        $this->assertDatabaseHas('comments', $updatedData);
    }

    public function test_delete_comment_request()
    {
        $response = $this->delete("/api/comments/{$this->createdComment->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('comments', ['id' => $this->createdComment->id]);
    }
}