<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikePostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "feedback_type" => $this->feedback_type == true ? "Лайк" : "Дизлайк",
            "created_at" => $this->created_at,
            "username" => $this->user->name,
            "email" => $this->user->email,
            "post" => PostResource::make($this->post)
        ];
    }
}
