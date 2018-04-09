<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function setUp() {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }

    public function testAUserCanViewAllThreads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);

    }

    public function testAUserCanReadASingleThread()
    {
        $this->get('/threads/' . $this->thread->id )
            ->assertSee($this->thread->title);
    }

    public function testAUserCanReadRepliesThatAreAssociatedWithAThread() {
        // And that thread includes replies
        $reply = factory(\App\Models\Reply::class)->create(['thread_id' => $this->thread->id]);
        // When we visit a thread page
        $this->get('/threads/' . $this->thread->id )
            ->assertSee( $reply->body );
        // Then we should see the replies

    }
}
