<?php

namespace App\Http\Builders\Filters;

class PostFilter extends QueryFilter
{
    /**
     * Метод для фильтрации по заголовку поста
     *
     * @param string $title
     * @return void
     */
    public function title(string $title): void
    {
        $this->builder->where("title", "like", "%$title%");
    }

    /**
     * Метод для фильтрации по тексту поста
     *
     * @param string $text
     * @return void
     */
    public function text(string $text): void
    {
        $this->builder->where("text", "like", "%$text%");
    }
}
