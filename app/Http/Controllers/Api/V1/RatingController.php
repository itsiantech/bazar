<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReviewRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\ProductWithRateResource;
use App\Models\Product;
use App\Services\ProductRating;

class RatingController extends Controller
{
    public function ReviewProduct(ProductReviewRequest $request, Product $product)
    {
        $formData = $request->validated();

        try {
            $rating = new ProductRating();

            $rating->rateProduct($product, $formData, auth()->id());

        }catch (\Exception $ex)
        {
            return response()->json([
                'status' => 500,
                'message' => $ex->getMessage()
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Product reviewed successfully'
        ]);
    }

    public function GetProductReviews(Product $product)
    {
        $reviews = $product->load('productReviews', 'productReviews.user');
//        dd($reviews);
        return response(ProductReviewResource::collection($reviews->productReviews), 200);
    }

    public function productRating(ProductRating $prating, Product $product)
    {
        $rating = $prating->getProductRating($product);
    }

    public function getTopRatedProducts(ProductRating $prating)
    {
        $ratedProducts = $prating->getTopRatedProduct(config('application.paginatePerPage.front'));

        return new PaginationResource($ratedProducts, ProductWithRateResource::class);
    }
}
