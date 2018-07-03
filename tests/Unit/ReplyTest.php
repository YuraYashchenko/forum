<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_reply_has_a_user()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->user);
    }

    /** @test */
    public function it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->addMonth();

        $this->assertTrue($reply->wasJustPublished());
    }

    /** @test */
    public function it_fetches_mentioned_users()
    {
        $reply = create('App\Reply', [
            'body' => '@johnDoe .. @janeDoe'
        ]);

        $this->assertEquals(['johnDoe', 'janeDoe'],  $reply->mentionedUsers());
    }

    /** @test */
    public function it_should_transform_reply_if_it_has_mentioned_users()
    {
        $reply = create('App\Reply', [
            'body' => 'Hey, @janeDoe!'
        ]);

        $this->assertEquals('Hey, <a href="/profiles/janeDoe">@janeDoe</a>!', $reply->body);
    }
}
