<?php

namespace App\Models;

use App\Services\ProductRating;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Services\ProductSold;

class TopProduct extends Model
{

    public function UpdateTopProducts($data)
    {

        $typeId = $data['id'];
        if ($typeId==1)
        {
            $this->SaveTopProducts($this->GetLatestProduct(),$typeId);
        }
        elseif ($typeId==2)
        {
            $this->SaveTopProducts($this->GetFeaturedProducts(),$typeId);
        }
        elseif ($typeId==3)
        {
            $this->SaveTopProducts($this->GetMostRatedProducts(),$typeId);
        }
        elseif ($typeId==4)
        {
            $this->SaveTopProducts($this->GetDiscountedProducts(),$typeId);
        }
        elseif ($typeId==5)
        {
            $this->SaveTopProducts($this->GetMostSoldProducts(),$typeId);
        }
    }

    public function GetLatestProduct()
    {
        return Product::where('is_active', 1)
            ->where('is_deleted', 0)
            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->orderby('id','desc')
            ->take(20)
            ->get();
    }

    public function GetMostRatedProducts()
    {
        $ratedProduct = new ProductRating();

        return $ratedProduct->getTopRatedProduct();
    }
    public function GetFeaturedProducts()
    {
        return Product::where('is_active', 1)
            ->where('is_deleted', 0)
            ->where('is_featured', 1)
            ->get();
    }

    public function GetDiscountedProducts()
    {
        return Product::whereNotNull('discount')
            ->where('discount','>',0)
            ->where('is_deleted', 0)
            ->paginate(config('application.paginatePerPage.front'));
    }

    public function GetMostSoldProducts()
    {
        $products = new ProductSold();

        return $products->getCurrentMonthTopSoldProducts(config('application.paginatePerPage.front'));
    }

    public function SaveTopProducts($products, $typeId)
    {
        DB::transaction(function () use($typeId,$products) {
            $this->DeleteProducts($typeId);
            TopProduct::insert($this->MakeData($products,$typeId));
        });
    }

    public function MakeData($products,$typeId)
    {
        $topProducts = [];
        foreach ($products as $key=>$product) {
            $topProducts[$key]['product_id'] = $product->id ;
            $topProducts[$key]['type_id'] = $typeId;
            $topProducts[$key]['created_at'] = Carbon::now();
            $topProducts[$key]['updated_at'] = Carbon::now();
        }
        return $topProducts;
    }

    public function DeleteProducts($typeId)
    {
        $products = TopProduct::where('type_id',$typeId)->count();

        if ($products>0)
        {
            return DB::table('top_products')->where('type_id',$typeId)->delete();

        }
        return true;
    }
}
