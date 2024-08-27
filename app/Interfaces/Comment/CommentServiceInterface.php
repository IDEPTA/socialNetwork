<?php

namespace App\Interfaces\Comment;

use App\Http\Requests\CommentValidation;
use App\Models\Comment;

interface CommentServiceInterface
{
    public function index(): Object;
    public function show(Comment $post): Comment;
    public function store(CommentValidation $req): Comment;
    public function update(CommentValidation $req, Comment $post): Comment;
    public function destroy(Comment $post): void;
}
