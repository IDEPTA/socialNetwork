<?php

namespace App\Services\Like;

use App\Models\PostLike;
use App\Http\Requests\PostLikeRequest;
use App\Interfaces\Like\PostLikeServiceInterface;

class PostLikeService implements PostLikeServiceInterface
{
    public function index(): object
    {
        $likes = PostLike::with(["user", "post"])->get();

        return $likes;
    }

    public function show(PostLike $like): PostLike
    {
        return $like;
    }

    public function store(PostLikeRequest $request): PostLike
    {
        $validationData = $request->validated();
        $newLike = PostLike::create($validationData);

        return $newLike;
    }

    public function update(PostLikeRequest $req, PostLike $like): PostLike
    {
        $validationData = $req->validated();
        $like->update($validationData);

        return $like;
    }

    public function destroy(PostLike $like): void
    {
        $like->delete();
    }
}
