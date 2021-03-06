<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notify(Thread $thread, Reply $reply)
    {
        $this->user->notify(new ThreadWasUpdated($thread, $reply));
    }
}
