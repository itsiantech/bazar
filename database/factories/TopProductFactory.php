<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\TopProduct::class, function (Faker $faker) {
    return [
        'product_id'=>rand(2,50),
        'type_id'=>rand(0,5)
    ];
});
