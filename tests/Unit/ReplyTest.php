<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_has_an_owner() {
    	$reply = factory(\App\Models\Reply::class)->create();

    	$this->assertInstanceOf( \App\Models\User::class, $reply->owner );
    }
}
