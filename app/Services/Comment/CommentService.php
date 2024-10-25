<?php

namespace App\Services\Comment;

use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CommentValidation;
use App\Interfaces\Comment\CommentServiceInterface;

class CommentService implements CommentServiceInterface
{
    public function index(): object
    {
        $comments = Comment::with(["post", "user"])->get();

        return $comments;
    }

    public function show(Comment $post): Comment
    {
        return $post;
    }

    public function store(CommentValidation $req): Comment
    {
        $validationData = $req->validated();
        $newComment = Comment::create($validationData);
        Log::info('Comment created:', $newComment->toArray());

        return $newComment;
    }

    public function update(CommentValidation $req, Comment $post): Comment
    {
        $validationData = $req->validated();
        $post->update($validationData);

        return $post;
    }

    public function destroy(Comment $post): void
    {
        $post->delete();
    }
}