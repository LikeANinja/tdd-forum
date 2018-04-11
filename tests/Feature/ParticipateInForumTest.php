<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{

        use DatabaseMigrations;

        /** @test */
        public function unauthenticated_users_may_not_add_replies() {

            $this->withExceptionHandling()
                ->post( 'threads/some-channel/1/replies', [] )
                ->assertRedirect('/login');

        }

        /** @test */
        public function an_authenticated_user_may_participate_in_forum_threads() {

        	// Given we have an authenticated user
                $this->signIn();

        	// And an existing thread
        	$thread = create( Thread::class );

        	// When the user adds a reply to the thread
        	$reply = make( Reply::class );
        	$this->post( $thread->path() . '/replies', $reply->toArray() );


        	// Then their reply should be included on the page
        	$this->get( $thread->path() )
        		->assertSee( $reply->body );

        }

        /** @test */
        public function a_reply_requires_a_body() {

            $this->withExceptionHandling()->signIn();

            $thread = create( Thread::class );

            $reply = make( Reply::class, ['body' => null] );
            $this->post( $thread->path() . '/replies', $reply->toArray() )
                ->assertSessionHasErrors('body');

        }
}
