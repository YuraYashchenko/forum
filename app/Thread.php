<?php

namespace App;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;


class Thread extends Model
{
    use Filterable, RecordsActivity;

    protected $fillable = ['title', 'body', 'user_id', 'channel_id'];

    protected $with = ['channel', 'user'];

    protected $appends = ['isSubscribed'];

    /**
     * Boot the model.
     */
    public static function boot(){
        parent::boot();

        static::addGlobalScope('replyCount', function ($query) {
            $query->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
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
     * @return Model
     */
    public function addReply($reply)
    {
        return $this->replies()->create($reply);
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

    /**
     * A user can subscribe on a thread.
     *
     * @param $userId
     */
    public function subscribe(int $userId)
    {
        $this->subscriptions()->create([
            'user_id' => $userId
        ]);
    }

    /**
     * A user can unsubscribe from a thread.
     *
     * @param $userId
     */
    public function unsubscribe(int $userId)
    {
        $this->subscriptions()->whereUserId($userId)->delete();
    }

    /**
     * ThreadSubscription relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }
}
