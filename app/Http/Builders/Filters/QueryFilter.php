<?php

namespace App\Http\Builders\Filters;

use App\Http\Builders\QueryBuilder;

/**
 * Базовый класс для всех фильтрации
 */
abstract class QueryFilter extends QueryBuilder
{
    protected function fields(): array
    {
        $filters = $this->request->json('filter') ?? [];
        return array_filter($filters, function ($value) {
            return $value !== null;
        });
    }
}
