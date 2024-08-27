<?php

namespace App\Interfaces\Post;

use App\Http\Requests\PostValidation;
use App\Models\Post;
use Illuminate\Http\Request;

interface PostServiceInterface
{
    public function index(): Object;
    public function show(Post $post): Post;
    public function store(PostValidation $req);
    public function update(PostValidation $req, Post $post): Post;
    public function destroy(Post $post): void;
}
