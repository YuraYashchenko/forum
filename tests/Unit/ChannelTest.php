<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_many_threads()
    {
        $channel = create('App\Channel');
        $thread = create('App\Thread', ['channel_id' => $channel->id]);

        self::assertTrue($channel->threads->contains($thread));
    }
}
