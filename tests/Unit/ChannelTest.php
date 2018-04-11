<?php

namespace Tests\Feature;

use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChannelTest extends TestCase {

	use RefreshDatabase;

	/** @test */
	public function a_channel_consists_of_threads() {

		$channel = create(Channel::class);

		$thread = create(\App\Models\Thread::class, ['channel_id' => $channel->id]);

		$this->assertTrue( $channel->threads->contains($thread));

	}
}