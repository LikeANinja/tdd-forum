<?php

namespace App\Filters;

use App\Filters\Filter;
use App\Models\User;

class ThreadFilter extends Filter
{
    protected $filters = ['by', 'popular', 'unanswered'];
    /**
     * Filter the query by a username
     * @param  string $username
     * @return Builder
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to the most popular thread
     * @return Builder
     */
    protected function popular()
    {
        return $this->builder->orderBy('replies_count', 'desc');
    }

    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}
