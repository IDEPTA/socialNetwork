<?php

namespace App\Http\Builders\Sorts;

class CommentSort extends QuerySort
{
    /**
     * Метод для сортировки по дате обновления
     *
     * @param string $updated_at
     * @return void
     */
    public function updated_at(string $updated_at): void
    {
        $this->builder->orderBy('updated_at', $updated_at);
    }


    /**
     * Метод для сортировки по дате создания
     *
     * @param string $created_at
     * @return void
     */
    public function created_at(string $created_at): void
    {
        $this->builder->orderBy('created_at', $created_at);
    }

    /**
     * Метод для сортировки по post_id
     *
     * @param string $post_id
     * @return void
     */
    public function post_id(string $post_id): void
    {
        $this->builder->orderBy('post_id', $post_id);
    }

    /**
     * Метод для сортировки по user_id
     *
     * @param string $user_id
     * @return void
     */
    public function user_id(string $user_id): void
    {
        $this->builder->orderBy('user_id', $user_id);
    }
}
