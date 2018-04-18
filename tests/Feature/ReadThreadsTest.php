<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function setUp()
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        // And that thread includes replies
        $reply = create(\App\Models\Reply::class, ['thread_id' => $this->thread->id]);
        // When we visit a thread page
        $this->get($this->thread->path())
            ->assertSee($reply->body);
        // Then we should see the replies
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(\App\Models\Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create(\App\Models\User::class, ['name' => 'JohnDoe']));

        $threadByJohn = create(Thread::class, ['user_id'=>auth()->id()]);
        $threadNotByJohn = create(Thread::class);

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {

        //given we have three threads
        //with 2 replies 3 replies and 0 replies respectively
        $threadWithTwoReplies = create(Thread::class);
        create(\App\Models\Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create(Thread::class);
        create(\App\Models\Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        //when i filter all threads by popularity
        $response = $this->get('threads?popular=1');
        $threadsFromResponse = $response->baseResponse->original->getData()['threads'];

        //then they should be returned fro most replies to least
        $this->assertEquals([3,2,0], $threadsFromResponse->pluck('replies_count')->toArray());
    }

    /** @test */
    public function a_guest_can_filter_threads_and_still_secondary_sort_by_time()
    {
        $secondThread = create(Thread::class, ['title' => 'Devon 2', 'created_at' => new Carbon('-2 minute')]);
        create(\App\Models\Reply::class, ['thread_id' => $secondThread->id]);

        $firstThread = create(Thread::class, ['title' => 'Devon 1', 'created_at' => new Carbon('-1 minutes')]);
        create(\App\Models\Reply::class, ['thread_id' => $firstThread->id]);

        $response = $this->get('threads?popular=1');
        $threadsFromResponse = $response->baseResponse->original->getData()['threads'];

        $this->assertEquals(['Devon 1', 'Devon 2'], $threadsFromResponse->pluck('title')->take(2)->all());
    }
}
