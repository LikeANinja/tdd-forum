<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Thread::class, function (Faker $faker) {
    return [
    	'user_id' => function() {
    		return factory('App\Models\User')->create()->id;
    	},
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
