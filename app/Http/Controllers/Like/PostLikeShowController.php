<?php

namespace App\Http\Controllers\Like;

use Exception;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikePostResource;
use App\Interfaces\PostRepository\PostLikeShowRepositoryInterface;

class PostLikeShowController extends Controller
{
    public function __construct(protected PostLikeShowRepositoryInterface $postsRepository) {}



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
