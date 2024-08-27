<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostValidation;
use App\Interfaces\Post\PostServiceInterface;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(protected PostServiceInterface $postService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posts = $this->postService->index();

            return response()->json(['posts' => $posts], 200);
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
    public function store(PostValidation $request)
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
    public function show(Post $post)
    {
        try {
            $concretePost = $this->postService->show($post);

            return response()->json(['post' => $concretePost]);
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
    public function update(PostValidation $req, Post $post)
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
    public function destroy(Post $post)
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
