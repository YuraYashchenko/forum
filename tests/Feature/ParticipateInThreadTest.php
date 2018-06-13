<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ParticipateInThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_cant_add_reply()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies', []);
    }

    /** @test */
    public function a_user_can_add_replies()
    {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make();

        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
