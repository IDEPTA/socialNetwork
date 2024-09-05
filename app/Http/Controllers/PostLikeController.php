<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikePostResource;
use Exception;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Interfaces\PostRepository\PostLikeRepositoryInterface;
use App\Models\Post;

class PostLikeController extends Controller
{
    public function __construct(protected PostLikeRepositoryInterface $postsRepository) {}

    public function getAllLikesPosts(): JsonResponse
    {
        try {
            $likes = $this->postsRepository->getAllLikesPosts();

            return response()->json([
                "likes" => LikePostResource::collection($likes)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function getAllDislikesPosts(): JsonResponse
    {
        try {
            $dislikes = $this->postsRepository->getAllDislikesPosts();

            return response()->json([
                "dislikes" => LikePostResource::collection($dislikes)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function getLikesForUser(User $user): JsonResponse
    {
        try {
            $likes = $this->postsRepository->getLikesForUser($user);

            return response()->json([
                "likes" => LikePostResource::collection($likes)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function getDislikesForUser(User $user): JsonResponse
    {
        try {
            $dislikes = $this->postsRepository->getDislikesForUser($user);

            return response()->json([
                "dislikes" => LikePostResource::collection($dislikes)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function getLikesForPost(Post $post): JsonResponse
    {
        try {
            $dislikes = $this->postsRepository->getLikesForPost($post);

            return response()->json([
                "dislikes" => LikePostResource::collection($dislikes)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }

    public function getDislikesForPost(Post $post): JsonResponse
    {
        try {
            $dislikes = $this->postsRepository->getDislikesForPost($post);

            return response()->json([
                "dislikes" => LikePostResource::collection($dislikes)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }
}
