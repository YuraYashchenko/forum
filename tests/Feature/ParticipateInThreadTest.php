<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ParticipateInThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_cant_add_reply()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();

        $thread = create('App\Thread');

        $this->post(route('add.reply', [$thread->channel->slug, $thread->id]), []);
    }

    /** @test */
    public function a_user_can_add_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post(route('add.reply', [$thread->channel->slug, $thread->id]), $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();

        $reply = make('App\Reply', ['body' => null]);
        $thread = create('App\Thread');

        $this->post(route('add.reply', [$thread->channel->slug, $thread->id]), $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
