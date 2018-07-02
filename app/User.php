<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * Get the value of the model's route key.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Fetch thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * Activity relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Cache key for recording visited thread in cache.
     *
     * @param Thread $thread
     * @return string
     */
    public function visitedThreadCacheKey(Thread $thread) : string
    {
        return sprintf("user.%s.visits.%s", $this->id, $thread->id);
    }

    /**
     * A user can read a thread.
     *
     * @param Thread $thread
     */
    public function read(Thread $thread)
    {
        cache()->forever(
            auth()->user()->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }
}
