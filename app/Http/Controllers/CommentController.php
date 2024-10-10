<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CommentResource;
use App\Http\Requests\CommentValidation;
use App\Interfaces\Comment\CommentServiceInterface;

class CommentController extends Controller
{
    public function __construct(protected CommentServiceInterface $commentService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $comments = $this->commentService->index();

            return response()->json([
                "comments" => CommentResource::collection($comments)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentValidation $request): JsonResponse
    {
        try {
            $newComment = $this->commentService->store($request);
            Log::info('Comment created:', $newComment->toArray());

            return response()->json(["newComment" => $newComment], 201);
        } catch (Exception $e) {
            Log::error('Error creating comment:', ['message' => $e->getMessage(), 'code' => $e->getCode()]);
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): JsonResponse
    {
        try {
            $comment = $this->commentService->show($comment);

            return response()->json([
                "comment" => CommentResource::make($comment)
            ]);
        } catch (Exception $e) {
            Log::error('Error creating comment:', ['message' => $e->getMessage(), 'code' => $e->getCode()]);
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentValidation $request, Comment $comment): JsonResponse
    {
        try {
            $updatedComment = $this->commentService->update($request, $comment);

            return response()->json(["comments" => $updatedComment], 200);
        } catch (Exception $e) {
            Log::error('Error creating comment:', ['message' => $e->getMessage(), 'code' => $e->getCode()]);
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        try {
            $this->commentService->destroy($comment);

            return response()->json(["msg" => "Комментарий удален"], 204);
        } catch (Exception $e) {
            Log::error('Error creating comment:', ['message' => $e->getMessage(), 'code' => $e->getCode()]);
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }
}