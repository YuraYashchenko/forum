<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class MentionUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_are_notified()
    {
        $johnDoe = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($johnDoe);

        $janeDoe = create('App\User', ['name' => 'JaneDoe']);

        $reply = make('App\Reply', ['body' => '@JaneDoe ....']);

        $this->post(route('replies.store', [$reply->thread->channel->slug, $reply->thread->id]), $reply->toArray());

        $this->assertCount(1, $janeDoe->notifications);
    }
}
