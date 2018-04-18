<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create(\App\Models\User::class);
        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /** @test */
    public function profiles_display_all_threads_by_user()
    {
        $user = create(\App\Models\User::class);

        $thread = create(\App\Models\Thread::class, ['user_id' => $user->id]);

        $this->get("/profiles/{$user->name}")
        	->assertSee($thread->title)
        	->assertSee($thread->body);
    }
}