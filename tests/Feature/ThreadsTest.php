<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAUserCanViewAllThreads()
    {
        $thread = factory('App\Models\Thread')->create();
        $response = $this->get('/threads');
        $response->assertSee($thread->title);

    }

    public function testAUserCanReadASingleThread()
    {

        $thread = factory('App\Models\Thread')->create();
        $response = $this->get('/threads/' . $thread->id );
        $response->assertSee($thread->title);
    }
}
