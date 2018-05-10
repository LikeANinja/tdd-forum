<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use Illuminate\Notifications\DatabaseNotification;

$factory->define(DatabaseNotification::class, function ($faker) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: factory(\App\Models\User::class)->create()->id;
        },
        'notifiable_type' => 'App\Models\User',
        'data' => ['foo' => 'bar']
    ];
});
