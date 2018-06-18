<?php


namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $builder;
    protected $request;

    /**
     * QueryFilter constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply filters to a model.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $key => $value)
        {
            if (method_exists($this, $key))
            {
                call_user_func([$this, $key], array_filter([$value]));
            }

            return $this->builder;
        }
    }

    /**
     * Get filters to request
     *
     * @return array
     */
    public function filters()
    {
        return $this->request->all();
    }
}