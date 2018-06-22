<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavouritesTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function a_guest_cant_favourite_anything()
    {
        $this->post(route('favourites.reply', 1))
            ->assertRedirect('/login');
    }
    
    /** @test */
    public function a_authenticated_user_can_favourite_a_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post(route('favourites.reply', $reply->id));

        $this->assertCount(1, $reply->favourites);
    }

    /** @test */
    public function an_authenticated_user_can_favourite_a_reply_once()
    {
        $this->signIn();
        $this->withoutExceptionHandling();

        $reply = create('App\Reply');

        $this->post(route('favourites.reply', $reply->id));
        $this->post(route('favourites.reply', $reply->id));

        $this->assertEquals(1, $reply->favourites()->count());
    }

    /** @test */
    public function an_authenticated_user_can_unfavourite_a_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $reply->favourite(auth()->id());
        $this->delete(route('unfavourites.reply', $reply->id));

        $this->assertCount(0, $reply->favourites);
    }
}
