<?php

namespace App;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;


class Thread extends Model
{
    use Filterable;

    protected $fillable = ['title', 'body', 'user_id', 'channel_id'];

    public static function boot(){
        parent::boot();

        static::addGlobalScope('replies_count', function ($query) {
            $query->withCount('replies');
        });
    }

      /**
     * Generate url for thread.
     *
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * Replies associated for thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * A thread related to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Add a reply to the thread.
     *
     * @param $reply
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    /**
     * Give a channel associated to a thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
