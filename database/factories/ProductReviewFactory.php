<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\ProductReview::class, function (Faker $faker) {
    return [
        'product_id'           => rand(1,2),
        'review_message'           =>  $faker->text,
        'rating'=>rand(1,5)
    ];
});
