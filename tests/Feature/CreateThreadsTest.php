<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function guests_may_not_create_threads() {
		// Given there is no user we expect an unauthenticated exception
		$this->expectException( \Illuminate\Auth\AuthenticationException::class );

    	// When we hit the end point to create a new thread
    	$thread = factory( Thread::class )->make();
    	$this->post('/threads', $thread->toArray() );

	}

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads() {

    	// Given we have a signed in user
    	$this->actingAs( factory(User::class)->create() );

    	// When we hit the end point to create a new thread
    	$thread = factory( Thread::class )->make();
    	$this->post('/threads', $thread->toArray() );

    	// Then when we visit the thread page
    	$this->get( $thread->path() )
    	// We should see the new thread
    		->assertSee($thread->title)
    		->assertSee($thread->body);

    }
}
