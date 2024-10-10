<?php

namespace App\Http\Controllers\Like;

use Exception;
use App\Models\PostLike;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostLikeRequest;
use App\Interfaces\Like\PostLikeServiceInterface;

class PostLikeController extends Controller
{
    public function __construct(protected PostLikeServiceInterface $likeService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $likes = $this->likeService->index();

            return response()->json(["likes" => $likes]);
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
    public function store(PostLikeRequest $request)
    {
        try {
            $newLike = $this->likeService->store($request);

            return response()->json(["newLike" => $newLike], 201);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PostLike $postLike)
    {
        try {
            $like = $this->likeService->show($postLike);

            return response()->json(["like" => $like]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostLikeRequest $request, PostLike $postLike)
    {
        try {
            $updatedLike = $this->likeService->update($request, $postLike);

            return response()->json(["updatedLike" => $updatedLike]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostLike $postLike)
    {
        $this->likeService->destroy($postLike);

        return response()->json([
            "msg" => "Запись $postLike->id удалена"
        ], 200);
    }
}