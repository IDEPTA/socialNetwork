<?php

namespace App\Http\Builders\Filters;

/**
 * Класс-фильтр для модели PostLike
 */
class PostLikeFilter extends QueryFilter
{
    /**
     * Метод для фильтрации по типу обратной связи
     *
     * @param bool $feedback_type
     * @return void
     */
    public function feedback_type(bool $feedback_type): void
    {
        $this->builder->where("feedback_type", $feedback_type);
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
