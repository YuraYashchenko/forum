<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_user_get_notification_when_thread_was_updated_not_to_user_that_created_this_thread()
    {
        $thread = create('App\Thread')->subscribe(auth()->id());

        $thread->addReply([
            'body' => 'Body',
            'user_id' => auth()->id()
        ]);

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'body' => 'Body',
            'user_id' => create('App\User')->id
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_delete_notifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(1, auth()->user()->unreadNotifications);

        $notification = auth()->user()->unreadNotifications->first();

        $this->delete(route('notifications.destroy', [
            'user' => auth()->user()->name,
            'notification' => $notification->id
        ]));

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }

    /** @test */
    public function a_user_can_fetch_all_unread_notifications()
    {
        create(DatabaseNotification::class);

        $response = $this->getJson(route('notifications.index', [
            'user' => auth()->user()->name
        ]))->json();

        $this->assertCount(1, $response);
    }
}
