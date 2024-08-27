<?php

namespace App\Interfaces\Post;

use App\Http\Requests\PostValidation;
use App\Models\Post;

interface PostServiceInterface
{
    public function index(): Object;
    public function show(Post $post): Post;
    public function store(PostValidation $req): Post;
    public function update(PostValidation $req, Post $post): Post;
    public function destroy(Post $post): void;
}
