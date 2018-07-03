<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\UserWasMentioned;
use App\User;


class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        $event->reply->mentionedUsers()->map(function ($name) {
            return User::whereName( $name)->first();
        })
        ->filter()
        ->each(function ($user) use ($event) {
            $user->notify(new UserWasMentioned($event->reply));
        });
    }
}
