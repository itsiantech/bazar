<?php


namespace App\Traits;


use Illuminate\Support\Facades\DB;

trait Rateable
{
    public function scopeRateProducts($query)
    {
        return $query->leftJoin('product_reviews', function ($join) {
            $join->on('products.id', '=', 'product_reviews.product_id');
        })
            ->addSelect(DB::raw('avg(`product_reviews`.rating) as rating'))
            ->whereNotNull('rating')
            ->groupBy('products.id');
    }
}
