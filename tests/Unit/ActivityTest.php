<?php

namespace Tests\Unit;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_activity_for_creating_a_thread()
    {
        $this->signIn($user = create('App\User'));

        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->assertDatabaseHas('activities', [
            'subject_type' => 'App\Thread',
            'subject_id' => $thread->id,
            'type' => 'created_thread',
            'user_id' => auth()->id()
        ]);

        $activity = Activity::first();

        $this->assertEquals($thread->id, $activity->subject->id);
    }

    /** @test */
    public function it_records_activity_for_creating_a_reply()
    {
        $this->signIn();
        create('App\Reply');

        $activities = Activity::all();

        $this->assertEquals(2, $activities->count());
    }

    /** @test */
    public function it_fetches_all_activity_for_a_user()
    {
        $this->signIn();

        create('App\Thread', ['user_id' => auth()->id()], 2);

        \DB::table('activities')
            ->whereUserId(auth()->id())
            ->limit(1)
            ->update([
                'created_at' => Carbon::now()->subWeek()
            ]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
