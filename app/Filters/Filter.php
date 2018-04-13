<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filter
{
    protected $request;
    protected $builder;
	protected $filters = [];

    /**
     * Threads filter constructor
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param  $builder Build object
     * @return $builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
        	if( method_exists($this, $filter) ){
        		$this->$filter($value);
        	}
        }

        return $this->builder;
    }

    public function getFilters() {
    	return $this->request->only($this->filters);
    }

}
