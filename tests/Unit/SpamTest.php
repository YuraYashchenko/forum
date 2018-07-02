<?php

namespace Tests\Unit;

use App\SpamDetection\Spam;
use Tests\TestCase;


class SpamTest extends TestCase
{
    /** @test */
    public function it_detects_invalid_keywords()
    {
        $spam = new Spam;

        $this->expectException(\Exception::class);

        $spam->detect('yahoo customer support');
    }

    /** @test */
    public function it_detects_key_hold_on()
    {
        $spam = new Spam;

        $this->expectException(\Exception::class);
        $spam->detect('Hello world aaaaaaaaaaa');
    }
}
