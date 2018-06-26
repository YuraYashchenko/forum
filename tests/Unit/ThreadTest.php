<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function it_has_a_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }
    
    /** @test */
    public function it_has_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->user);
    }

    /** @test */
    public function it_belongs_to_chanel()
    {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }
    
    /** @test */
    public function it_should_return_correct_path()
    {
        $this->assertEquals("/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path());
    }
    
    /** @test */
    public function it_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foo',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function it_can_be_subscribed_to_a_user()
    {
        $this->signIn();

        $this->thread->subscribe(auth()->id());

        $this->assertEquals(1, $this->thread->subscriptions()->where('user_id', auth()->id())->count());
    }

    /** @test */
    public function it_can_be_unsubscribed_from_a_user()
    {
        $this->signIn();

        $this->thread->unsubscribe(auth()->id());

        $this->assertEquals(0, $this->thread->subscriptions()->where('user_id', auth()->id())->count());
    }
}
