<?php

namespace App\Interfaces\Like;

use App\Http\Requests\PostLikeRequest;
use App\Models\PostLike;

interface PostLikeServiceInterface
{
    public function index(): object;
    public function show(PostLike $like): PostLike;
    public function update(PostLikeRequest $req, PostLike $like): PostLike;
    public function store(PostLikeRequest $req): PostLike;
    public function destroy(PostLike $like): void;
}
