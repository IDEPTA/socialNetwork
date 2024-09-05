<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Models\User;
use App\Models\PostLike;
use App\Interfaces\PostRepository\PostLikeShowRepositoryInterface;

class PostLikeRepository implements PostLikeShowRepositoryInterface
{
    /**
     * Create a new class instance.
     */

    public function getLikesForPost(Post $post): object
    {
        $likes = PostLike::with(["user", "post"])
            ->where("feedback_type", true)
            ->where("post_id", $post->id)
            ->get();

        return $likes;
    }
    public function getLikesForUser(User $user): object
    {
        $likes = PostLike::with(["user", "post"])
            ->where("feedback_type", true)
            ->where("user_id", $user->id)
            ->get();

        return $likes;
    }

    public function getDislikesForUser(User $user): object
    {
        $dislikes = PostLike::with(["user", "post"])
            ->where("feedback_type", false)
            ->where("user_id", $user->id)
            ->get();

        return $dislikes;
    }

    public function getDislikesForPost(Post $post): object
    {
        $dislikes = PostLike::with(["user", "post"])
            ->where("feedback_type", false)
            ->where("post_id", $post->id)
            ->get();

        return $dislikes;
    }
}
