<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        // Sign in the user
        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        // when the user is signed in
        // and we have a thread that is subscribed to
        $thread = create(\App\Models\Thread::class)->subscribe();

        // *Sanity check that there is no notifications*
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        // then, when the logged in user leaves a reply
        $reply = make(\App\Models\Reply::class, ['user_id' => auth()->id()]);
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'some body'
        ]);

        // then there should be no notification for the user
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        // and when a user that is not the logged in user leaves a reply
        $thread->addReply([
            'user_id' => create(\App\Models\User::class)->id,
            'body' => 'some body'
        ]);

        // then a notification should be prepared for the user
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {

    	// Prepare a notification for the user
    	create(DatabaseNotification::class);

        // and we get all notifications
        // then a notification is returned
        $this->assertCount(1, $this->getJson("/profiles/" . auth()->user()->name . "/notifications/")->json());
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {

    	// Prepare a notification for the user
    	create(DatabaseNotification::class);

        // then a notification is prepared for the user
        $user = auth()->user();
        $this->assertCount(1, $user->unreadNotifications);

        // then when a user deletes the notification
        $notificationId = $user->unreadNotifications->first()->id;
        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        // the prepared notification should not be returned
        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
