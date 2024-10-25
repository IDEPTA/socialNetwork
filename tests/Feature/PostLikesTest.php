<?php

namespace Tests\Feature;

use App\Models\PostLike;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class PostLikesTest extends TestCase
{
    public function test_store_postlike_request()
    {
        $newPostLike = [
            "user_id" => 1,
            "post_id" => 1,
            "feedback_type" => true
        ];

        $response = $this->post("/api/postLikes", $newPostLike);

        Log::channel("testing_results_request")
            ->info("STORE PostLike", ['data' => $response['newLike']]);

        $response->assertCreated();
        $this->assertDatabaseHas("post_likes", $newPostLike);
    }

    public function test_index_postlike_request()
    {
        $response = $this->get("/api/postLikes");

        $response->assertStatus(200);
        $response->assertHeader("Content-type", "application/json");
    }

    public function test_show_postlike_request()
    {
        $postLike = PostLike::orderBy("id", "desc")->first();
        $response = $this->get("/api/postLikes/{$postLike->id}");

        Log::channel("testing_results_request")
            ->info("SHOW PostLike", [
                'id' => $postLike->id,
                'data' => $response['like']
            ]);
        $response->assertStatus(200);
    }

    public function test_update_postlike_request()
    {
        $postLike = PostLike::orderBy("id", "desc")->first();
        $updatedPostLike = [
            "user_id" => 1,
            "post_id" => 1,
            "feedback_type" => false
        ];

        $response = $this->put("/api/postLikes/{$postLike->id}", $updatedPostLike);
        Log::channel("testing_results_request")
            ->info("UPDATED PostLike", ['data' => $response['updatedLike']]);

        $response->assertOk();
        $this->assertDatabaseHas("post_likes", $updatedPostLike);
    }

    public function test_delete_postlike_request()
    {
        $postLike = PostLike::orderBy("id", "desc")->first();
        $response = $this->delete("/api/postLikes/{$postLike->id}");

        Log::channel("testing_results_request")
            ->info("DELETED PostLike", [
                'id' => $postLike->id,
                'data' => $response['msg']
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing("post_likes", ['id' => $postLike->id]);
    }
}