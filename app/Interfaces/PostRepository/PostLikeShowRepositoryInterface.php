<?php

namespace App\Interfaces\PostRepository;

use App\Models\Post;
use App\Models\User;

interface PostLikeShowRepositoryInterface
{

    public function getLikesForPost(Post $post): object;
    public function getDislikesForPost(Post $post): object;

    public function getLikesForUser(User $user): object;
    public function getDislikesForUser(User $user): object;
}
