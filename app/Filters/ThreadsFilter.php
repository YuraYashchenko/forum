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
}