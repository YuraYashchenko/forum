<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create('App\User');

        $this->get(route('profiles.show', $user->name))
            ->assertSee($user->name);
    }

    /** @test */
    public function a_user_profile_contains_all_threads_published_by_user()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get(route('profiles.show', auth()->user()->name))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
