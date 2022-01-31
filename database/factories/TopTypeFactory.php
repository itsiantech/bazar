<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\TopType::class, function (Faker $faker) {
    return [
        'name'=>'Top type'.rand(0,5)

    ];
});
