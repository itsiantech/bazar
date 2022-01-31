<?php


namespace App\Services;


use App\Models\Product;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductRating
{
    public function rateProduct(Product $product, array $formData, int $userId): void
    {
        $formData['user_id'] = $userId;
        $product->product_reviews()->updateOrCreate(['user_id' => $formData['user_id']], $formData);
    }

    public function getProductRating(Product $product): float
    {
        return $product->productReviews()->average('rating');
    }

    public function getTopRatedProduct(int $perPage = 10): LengthAwarePaginator
    {
        return Product::query()
            ->selectRaw('`products`.*')
            ->rateProducts()
            ->paginate($perPage);
    }


}
