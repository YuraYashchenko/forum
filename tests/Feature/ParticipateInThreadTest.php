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

        $this->post(route('replies.store', [$thread->channel->slug, $thread->id]), []);
    }

    /** @test */
    public function a_user_can_add_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post(route('replies.store', [$thread->channel->slug, $thread->id]), $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function unauthorized_user_cant_update_a_reply()
    {
        $reply = create('App\Reply');

        $this->patch(route('replies.update', $reply->id), [])
            ->assertRedirect('/login');

        $this->signIn()->patch(route('replies.update', $reply->id), [])
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_a_reply()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->patch(route('replies.destroy', $reply->id), ['body' => 'Updated reply.']);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => 'Updated reply.']);
    }

    /** @test */
    public function unauthorized_user_cant_delete_a_reply()
    {
        $reply = create('App\Reply');

        $this->delete(route('replies.destroy', $reply->id))
            ->assertRedirect('/login');

        $this->signIn()->delete(route('replies.destroy', $reply->id))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_reply()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete(route('replies.destroy', $reply->id));

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();

        $reply = make('App\Reply', ['body' => null]);
        $thread = create('App\Thread');

        $this->post(route('replies.store', [$thread->channel->slug, $thread->id]), $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
