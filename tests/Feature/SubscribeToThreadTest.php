<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_subscribe_to_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $this->post(route('subscriptions.store', [
            'channel_id' => $thread->channel->name,
            'thread' => $thread->id
        ]));

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    /** @test */
    public function an_authenticated_user_can_unsubscribe_from_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $thread->subscribe(auth()->id());

        $this->delete(route('subscriptions.destroy', [
            'channel_id' => $thread->channel->name,
            'thread' => $thread->id
        ]));

        $this->assertCount(0, $thread->fresh()->subscriptions);
    }
}
