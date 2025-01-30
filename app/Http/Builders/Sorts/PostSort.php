<?php

namespace App\Http\Builders\Sorts;

class PostSort extends QuerySort
{
    /**
     * Метод для сортировки постов по дате создания
     *
     * @param string $created_at
     * @return void
     */
    public function created_at(string $created_at): void
    {
        $this->builder->orderBy('created_at', $created_at);
    }

    /**
     * Метод для сортировки постов по дате обновления
     *
     * @param string $updated_at
     * @return void
     */
    public function updated_at(string $updated_at): void
    {
        $this->builder->orderBy('updated_at', $updated_at);
    }
}
