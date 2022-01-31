<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) use ($factory) {
    return [
        'name_en'=> 'Product'.rand(0,20).'_en',
        'name_bn'=>'Product '.rand(0,20).'_bn',
        'description_en'=>$faker->text.'_en',
        'description_bn'=>$faker->text.'_bn',
        'vat_percent'=>$faker->numberBetween(0,20),
        'tax_percent'=>$faker->numberBetween(0,20),
        'discount_percent'=>$faker->numberBetween(0,70),
        'featured_image'=>$faker->image(),
        'price_en'=>$faker->numberBetween(0,1000),
        'price_bn'=>$faker->numberBetween(0,1000),
        'quantity'=>$faker->numberBetween(0,10),
        'unite'=>'KG',
        'category_id'=> rand(1, 25)
    ];
});
