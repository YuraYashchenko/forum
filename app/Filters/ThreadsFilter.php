<?php


namespace App\Filters;


use App\User;

class ThreadsFilter extends QueryFilter
{
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        $this->builder->whereUserId($user->id);
    }

    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        $this->builder->orderBy('replies_count', 'desc');
    }
}