<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductTopSoldResource;
use App\Models\Product;
use App\Services\ProductSold;
use Illuminate\Http\Request;

class ProductSoldController extends Controller
{
    public function getCurrentMonthTopSoldProducts(ProductSold $productSold):PaginationResource
    {
        $products = $productSold->getCurrentMonthTopSoldProducts(config('application.paginatePerPage.front'));
        return new PaginationResource($products, ProductTopSoldResource::class);
    }

    public function getCurrentYearTopSoldProducts(ProductSold $productSold):PaginationResource
    {
        $products = $productSold->getCurrentYearTopSoldProducts(config('application.paginatePerPage.front'));
        return new PaginationResource($products, ProductTopSoldResource::class);
    }

    public function getAllTimeTopSoldProducts(ProductSold $productSold):PaginationResource
    {
        $products = $productSold->getTopSoldProducts(config('application.paginatePerPage.front'));
        return new PaginationResource($products, ProductTopSoldResource::class);
    }

}

