<?php

namespace Tests\Unit;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;
    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create(Thread::class);

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(\App\Models\User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(\App\Models\Channel::class, $thread->channel);
    }


    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'fooBar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        // Given we have a thread
        $thread = create(\App\Models\Thread::class);
        // when the user subscribes to the thread
        $thread->subscribe($userId = 1);
        // then we should be able to fetch all threads that the user has subscribed to
        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', $userId)->count()
        );
    }

    /** @test */
    public function a_test_can_be_unsubscribed_from()
    {
        // Given we have a thread
        $thread = create(\App\Models\Thread::class);
        // and a user who is subscribed to the thread
        $thread->subscribe($userId = 1);
        // and they unsubscribe from a thread
        $thread->unsubscribe($userId);
        // then we should have 0 subscriptions on this thread
        $this->assertCount(
            0,
            $thread->subscriptions
        );
    }

    /** @test */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        // Given we have a thread
        $thread = create(\App\Models\Thread::class);

        // And the user is signed in
        $this->signIn();

        // The thread should know the user is not subscribed to it
        $this->assertFalse($thread->isSubscribedTo);

        // And the user subscribes to the thread
        $thread->subscribe();

        // The thread should know the user is subscribed to it
        $this->assertTrue($thread->isSubscribedTo);
    }
}
