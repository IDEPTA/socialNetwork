<?php

namespace App\Traits;

use App\Http\Builders\Sorts\QuerySort;
use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    public function scopeSort(Builder $builder, QuerySort $sort)
    {
        $sort->apply($builder);
    }
}
