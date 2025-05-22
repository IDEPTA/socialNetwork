<?php

namespace App\Http\Controllers\Like;

use Exception;
use App\Jobs\SendLogJob;
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

            $feedbackType = $newLike->feedback_type ? "лайк" : "дизлайк";
            $msg = "Поставлен " .
                $feedbackType  .
                " на пост с id = " . $newLike->post_id .
                " от пользователя с id = " . $newLike->user_id . " " . $newLike->user->name;
            SendLogJob::dispatch($msg, 'info', $newLike->toArray());

            return response()->json(["newLike" => $newLike->toArray()], 201);
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

            $feedbackType = $updatedLike->feedback_type ? "лайк" : "дизлайк";
            $msg = "Пользователь с id = " . $updatedLike->user_id . " " . $updatedLike->user->name . " изменил оценку на " .
                $feedbackType  .
                " для поста с id = " . $updatedLike->post_id;
            SendLogJob::dispatch($msg, 'info', $updatedLike->toArray());

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

        $feedbackType = $postLike->feedback_type ? "лайк" : "дизлайк";
        $msg = "Пользователь с ID" . $postLike->user_id . " " . $postLike->user->name . " убрал оценку " .
            $feedbackType  .
            " для поста с ID" . $postLike->post_id;
        SendLogJob::dispatch($msg, 'info', $postLike->toArray());

        return response()->json([
            "msg" => "Запись $postLike->id удалена"
        ], 200);
    }
}
