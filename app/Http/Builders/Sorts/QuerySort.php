<?php

namespace App\Http\Builders\Sorts;

use App\Http\Builders\QueryBuilder;

/**
 * Базовый класс для всех классов сортировки
 */
abstract class QuerySort extends QueryBuilder
{
    protected function fields(): array
    {
        return array_filter(
            array_map(
                'trim',
                $this->request->json('sort') != null ?
                    $this->request->json('sort') :
                    []
            )
        );
    }
}
