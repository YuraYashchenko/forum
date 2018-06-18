<?php


namespace App\Filters;


trait Filterable
{
    /**
     * Add filter method to the model.
     *
     * @param $query
     * @param QueryFilter $filter
     */
    public function scopeFilter($query, QueryFilter $filter)
    {
        $filter->apply($query);
    }
}