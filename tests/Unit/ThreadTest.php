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

	public function setUp() {
		parent::setUp();
    	$this->thread = create( Thread::class );
	}

    /** @test */
    public function a_thread_can_make_a_string_path() {
        $thread = create( Thread::class );

        $this->assertEquals( "/threads/{$thread->channel->slug}/{$thread->id}", $thread->path() );
    }

    /** @test */
    public function a_thread_has_a_creator() {
    	$this->assertInstanceOf( \App\Models\User::class, $this->thread->creator );
    }

    /** @test */
    public function a_thread_has_replies() {
        $this->assertInstanceOf( \Illuminate\Database\Eloquent\Collection::class, $this->thread->replies );
    }

    /** @test */
    public function a_thread_belongs_to_a_channel() {

        $thread = create( Thread::class );

        $this->assertInstanceOf( \App\Models\Channel::class, $thread->channel);

    }


    /** @test */
    public function a_thread_can_add_a_reply() {
    	$this->thread->addReply([
    		'body' => 'fooBar',
    		'user_id' => 1
    	]);

    	$this->assertCount(1, $this->thread->replies );
    }
}
