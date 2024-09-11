<?php

namespace App\Services\Post;

use App\Http\Requests\PostValidation;
use App\Interfaces\Post\PostServiceInterface;
use App\Models\Post;

class PostService implements PostServiceInterface
{
    public function index(): object
    {
        $posts = Post::with(["comment", "user"])->get();

        return $posts;
    }

    public function show(Post $post): Post
    {
        return $post;
    }

    public function store(PostValidation $req): Post
    {
        $validationData = $req->validated();

        if ($req->hasFile("images")) {
            $imageUrls = [];
            foreach ($req->images as $image) {
                $path = $image->store("images");
                $imageUrls[] = "/storage/" . $path;
            }
        }

        $validationData['images'] = json_encode($imageUrls);
        $newPost = Post::create($validationData);

        return $newPost;
    }

    public function update(PostValidation $req, Post $post): Post
    {
        $validationData = $req->validated();
        $imageUrls = [];

        if ($req->hasFile("images")) {
            foreach ($req->images as $image) {
                $path = $image->store("images");
                $imageUrls[] = $path;
            }
        }

        $validationData['images'] = $imageUrls;
        $post->update($validationData);

        return $post;
    }

    public function destroy(Post $post): void
    {
        $post->delete();
    }
}
