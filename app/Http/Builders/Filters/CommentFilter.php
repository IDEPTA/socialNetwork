<?php

namespace App\Http\Builders\Filters;

class CommentFilter extends QueryFilter
{
    /**
     * Метод для фильтрации по тексту комментария
     *
     * @param string $text
     * @return void
     */
    public function text(string $text): void
    {
        $this->builder->where("text", "like", "%$text%");
    }

    /**
     * Метод для фильтрации по post_id
     *
     * @param int $post_id
     * @return void
     */
    public function post_id(int $post_id): void
    {
        $this->builder->where("post_id", $post_id);
    }

    /**
     * Метод для фильтрации по user_id
     *
     * @param int $user_id
     * @return void
     */
    public function user_id(int $user_id): void
    {
        $this->builder->where("user_id", $user_id);
    }
}
