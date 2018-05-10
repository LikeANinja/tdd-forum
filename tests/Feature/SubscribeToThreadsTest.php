<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_subscribe_to_threads()
    {
        // Given the user is signed in
        $this->signIn();

        // and we have a thread
        $thread = create(\App\Models\Thread::class);

        // and the user subscribes
        $this->post($thread->path() . '/subscriptions');

        // then the thread should have a subscription count of 1
        $this->assertCount(1, $thread->fresh()->subscriptions);

    }

    /** @test */
    public function a_user_can_unsubscribe_from_a_thread()
    {
        // Given the user is signed in
        $this->signIn();

        // and we have a thread
        $thread = create(\App\Models\Thread::class);

        // and the user is subscribed to the thread
        $thread->subscribe();

        // and the user unsubscribes to the thread
        $this->delete($thread->path() . '/subscriptions');

        // the user is no longer subscribed to the thread
        $this->assertCount(0, $thread->subscriptions);
    }
}
