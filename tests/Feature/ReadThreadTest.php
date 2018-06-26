<?php

namespace Tests\Feature;

use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_get_all_threads()
    {
        $this->get(route('threads.index'))
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    /** @test */
    public function a_user_can_get_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_a_channel()
    {
        $this->withoutExceptionHandling();
        $channel = create('App\Channel');

        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get(route('sort.channel', [$channel->slug]))
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->withoutExceptionHandling();
        $this->signIn($user = create('App\User', ['name' => 'JohnDoe']));

        $threadByJohnDoe = create('App\Thread', ['user_id' => $user->id]);
        $threadNotByJohnDoe = create('App\Thread');

        $this->get('/threads?by=' . $user->name)
            ->assertSee($threadByJohnDoe->title)
            ->assertDontSee($threadNotByJohnDoe->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);


        $response = $this->getJson(route('threads.index') . '?popular')
            ->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

    /** @test */
    public function a_user_can_fetch_unanswered_threads()
    {
        $unansweredThread = create('App\Thread');

        create('App\Reply', ['thread_id' => $unansweredThread->id]);

        $response = $this->getJson(route('threads.index') . '?unanswered')->json();

        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_user_can_fetch_all_replies_for_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 3);

        $response = $this->getJson(route('replies.index', [
            'channel' => $thread->channel->name,
            'thread' => $thread->id
        ]))->json();

        $this->assertEquals(3, $response['total']);
        $this->assertCount(2, $response['data']);
    }
}
