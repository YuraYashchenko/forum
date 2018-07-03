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
        User::whereIn('name', $event->reply->mentionedUsers())
        ->each(function ($user) use ($event) {
            $user->notify(new UserWasMentioned($event->reply));
        });
    }
}
