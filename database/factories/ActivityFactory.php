<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Activity;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    $user = User::find($faker->numberBetween($min = 1, $max = 10));
    return [
        'user_id'       => $user->id,
        'description'   => $faker->text($maxNbChars = 80),
    ];
});
