<?php

namespace App\Post;

use App\Http\Requests\PostValidation;
use App\Interfaces\Post\PostServiceInterface;
use App\Models\Post;

class PostService implements PostServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index(): object
    {
        $posts = Post::all();

        return $posts;
    }

    public function show(Post $post): Post
    {
        return $post;
    }

    public function store(PostValidation $req)
    {
        $validationData = $req->validated();

        if ($req->hasFile("images")) {
            $imageUrls = [];
            foreach ($req->images as $image) {
                $path = $image->store("images");
                $imageUrls[] = "/storage/" . $path;
            }
            $validationData['images'] = $imageUrls;
        }
        $newPost = Post::create($validationData);

        return $newPost;
    }

    public function update(PostValidation $req, Post $post): Post
    {
        $validationData = $req->validated();

        if ($req->hasFile("images")) {
            $imageUrls = [];
            foreach ($req->images as $image) {
                $path = $image->store("images");
                $imageUrls[] = [
                    "image" => "/storage/" . $path
                ];
            }
            $validationData['images'] = $imageUrls;
        }

        $post->update($validationData);

        return $post;
    }

    public function destroy(Post $post): void
    {
        $post->delete();
    }
}
