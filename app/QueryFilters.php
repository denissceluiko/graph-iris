<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilters
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value)
        {
            if (!method_exists($this, $filter)) continue;

            if (empty($value)) {
                $this->$filter();
            } else {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * @return mixed
     */
    public function filters()
    {
        return $this->request->all();
    }

    public function except($filter)
    {
        return $this->request->except($filter);
    }

    public function has($filter)
    {
        return $this->request->has($filter);
    }

    public function get($filter)
    {
        return $this->request->get($filter);
    }
}