<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    return [
    	'thread_id' => function() {
    		return factory('App\Models\Threada')->create()->id;
    	},
    	'user_id' => function() {
    		return factory('App\Models\User')->create()->id;
    	},
        'body' => $faker->paragraph
    ];
});
