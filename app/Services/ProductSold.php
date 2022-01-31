<?php


namespace App\Services;


use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductSold
{
    protected $product;

    public function set(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function incrementSoldProduct(int $qty = 1):int
    {
        return $this->getCurrentMonthProductSold()->increment('sold',$qty);
    }


    public function decrementSoldProduct(int $qty = 1):int
    {
        return $this->getCurrentMonthProductSold()->decrement('sold',$qty);
    }

    public function findCurrentMonthProductSold()
    {
        return $this->product->product_sold()->whereYear('created_at', now()->format('Y'))->whereMonth('created_at', now()->format('m'))->first();
    }

    public function getCurrentMonthProductSold(): \App\Models\ProductSold
    {
        $soldProduct = $this->findCurrentMonthProductSold();

        if(empty($soldProduct)) return $this->createEmptyProductSold();

        return $soldProduct;
    }


    public function createEmptyProductSold(): \App\Models\ProductSold
    {
        return $this->product->product_sold()->create(['sold' => 0]);
    }

    public function getCurrentMonthTopSoldProducts(int $maxItems = 10):LengthAwarePaginator
    {
        return Product::query()
            ->leftJoin('product_solds', function ($join) {
                $join->on('products.id', '=', 'product_solds.product_id')
                    ->whereMonth('product_solds.created_at', now()->format('m'))
                    ->whereYear('product_solds.created_at', now()->format('Y'));
            })
            ->selectRaw('products.*, product_solds.sold')
            ->whereNotNull('product_solds.sold')
            ->orderBy('sold', 'desc')
            ->paginate($maxItems);
    }

    public function getTopSoldProducts(int $maxItems = 10):LengthAwarePaginator
    {
        return Product::query()
            ->leftJoin('product_solds', function ($join) {
                $join->on('products.id', '=', 'product_solds.product_id')
                    ->whereMonth('product_solds.created_at', now()->format('m'))
                    ->whereYear('product_solds.created_at', now()->format('Y'));
            })
            ->selectRaw('products.*, sum(product_solds.sold) as sold')
            ->whereNotNull('product_solds.sold')
            ->groupBy('products.id')
            ->orderBy('sold', 'desc')
            ->paginate($maxItems);
    }

    public function getCurrentYearTopSoldProducts(int $maxItems = 10):LengthAwarePaginator
    {
        return Product::query()
            ->leftJoin('product_solds', function ($join) {
                $join->on('products.id', '=', 'product_solds.product_id')
                    ->whereYear('product_solds.created_at', now()->format('Y'));
            })
            ->selectRaw('products.*, sum(product_solds.sold) as sold')
            ->whereNotNull('product_solds.sold')
            ->groupBy('products.id')
            ->orderBy('sold', 'desc')
            ->paginate($maxItems);
    }

    public function getSpecificYearTopSoldProducts(int $year, int $maxItems = 10):LengthAwarePaginator
    {
        return Product::query()
            ->leftJoin('product_solds', function ($join) use($year) {
                $join->on('products.id', '=', 'product_solds.product_id')
                    ->whereYear('product_solds.created_at', $year);
            })
            ->selectRaw('products.*, sum(product_solds.sold) as sold')
            ->whereNotNull('product_solds.sold')
            ->groupBy('products.id')
            ->orderBy('sold', 'desc')
            ->paginate($maxItems);
    }

}
