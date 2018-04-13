<?php

namespace App\Filters;

use App\Filters\Filter;
use App\Models\User;

class ThreadFilter extends Filter
{

	protected $filters = ['by'];
	/**
	 * Filter the query by a username
	 * @param  string $username
	 * @return mixed
	 */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}
