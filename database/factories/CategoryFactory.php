<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    return [
        'name_en'=>'Category'.rand(0,20).'_en',
        'name_bn'=>'Category'.rand(0,20)."_bn",
        'image'=>'',
        'icon'=>''
    ];
});
