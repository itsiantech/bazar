<?php

namespace App\Traits;

use App\Models\Bundle;
use App\Models\Product;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Cast\Object_;

trait BundleTrait
{
    private $previousBundles;

    public function syncBundles($products)
    {
        $this->previousBundles = $this->bundle_products()->get();

        $previousBundlesProductId = $this->previousBundles->pluck('product_id')->all();

        $productsToBeInserted = $this->DeleteProductFromDatabase($previousBundlesProductId, $products);

        return $this->BundleToBeCreated($productsToBeInserted);
    }

    public function BundleProducts()
    {
        $product = $this->load('bundle_products.productDetails');

        $bundles = $product->bundle_products;
        $products = [];

        foreach ($bundles as $bundle)
        {
            $product = $bundle->productDetails->toArray();
            $product['bundle_id'] = $bundle->id;
            $product['quantity'] = $bundle->quantity;
            $product = json_decode(json_encode($product));
            array_push($products, $product);
        }
        return $products;
    }


    private function DeleteProductFromDatabase(Array $previousBundlesProductId, Array $products): array
    {
        $productsToBeDeleted = [];

        foreach ($previousBundlesProductId as $key=>$value){
            if(!in_array($value, $products))
                array_push($productsToBeDeleted, $value);
        }

        $this->bundle_products()->whereIn('product_id', $productsToBeDeleted)->delete();

        return array_diff( $products, $productsToBeDeleted );

    }

    private function BundleToBeCreated(Array $productsToBeInserted):object
    {
        $productsToBeInserted = $this->PreventDuplicateEntry($productsToBeInserted);

        $bundlesToBeInserted = [];

        foreach ($productsToBeInserted as $key => $value) {
            $p = Product::find($value);
            $bundlesToBeInserted[$key] = ['product_id' => $p->id];
        }

        return $this->bundle_products()->createMany($bundlesToBeInserted);
    }

    private function PreventDuplicateEntry(Array $productsToBeInserted):array
    {
        $productsToBeInsertedFiltered = [];

        foreach ($productsToBeInserted as $key => $value) {
            if(!$this->previousBundles->contains('product_id', $value)){
                array_push($productsToBeInsertedFiltered, $value);
            }
        }

        return $productsToBeInsertedFiltered;
    }


    public function calculateBundleTotal(array $bundleProducts = []):array
    {
        $total = [
            'price' => 0,
            'saved' => 0,
            'grandTotal' => 0,
        ];

        if(empty($bundleProducts)) $bundleProducts = $this->BundleProducts();

        $price = array_map(function($item){
            return $item->price_en*$item->quantity;
        }, $bundleProducts);

        $price = collect($price)->sum();

        $discount = $this->calculateDiscount($this->bundle, $price);
        $grandTotal = $this->calculateGrandTotalAfterDiscount($price, $discount);

        $total['price'] = $price;
        $total['saved'] = $discount;
        $total['grandTotal'] = $grandTotal;

        return $total;
    }

    public function calculateDiscount(?Bundle $bundle, float $price)
    {
        $discount = !empty($bundle)?$bundle->discount:0;
        $isPercent = !empty($bundle)?$bundle->is_percent:0;

        if($isPercent) return ($price*$discount)/100;

        return $discount;
    }

    public function calculateGrandTotalAfterDiscount(float $total, float $discount):float
    {
        return $total - $discount;
    }




}
