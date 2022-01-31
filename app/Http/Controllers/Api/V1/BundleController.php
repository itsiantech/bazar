<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BundleResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class BundleController extends Controller
{
    public function BundleProducts(Product $product)
    {
        return ProductResource::collection($product->BundleProducts());
    }

    public function Bundles()
    {
        return BundleResource::collection(Product::whereHas('bundle')->get());
    }
}
