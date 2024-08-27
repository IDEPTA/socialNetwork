<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostValidation;
use App\Http\Resources\PostResource;
use App\Interfaces\Post\PostServiceInterface;
use App\Models\Post;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends Controller
{
    public function __construct(protected PostServiceInterface $postService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $posts = $this->postService->index();

            return response()->json([
                'posts' => PostResource::collection($posts)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostValidation $request): JsonResponse
    {
        try {
            $newPost = $this->postService->store($request);

            return response()->json(['newPost' => $newPost], 200);
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        try {
            $concretePost = $this->postService->show($post);

            return response()->json([
                'post' => PostResource::make($concretePost)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostValidation $req, Post $post): JsonResponse
    {
        try {
            $updatedPost = $this->postService->update($req, $post);

            return response()->json(['updatedPost' => $updatedPost]);
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): JsonResponse
    {
        try {
            $this->postService->destroy($post);

            return response()->json(['msg' => 'Пост удален']);
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
