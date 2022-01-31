<?php

namespace App\Models;

use App\Models\Brand;
use App\Services\SearchService;
use App\Traits\BundleTrait;
use App\Traits\CommonFunctions;
use App\Traits\ProductSoldTrait;
use App\Traits\Rateable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use CommonFunctions, BundleTrait, Rateable;

    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'category_id',
        'owner_id',
        'discount_id',
        'brand_id',
        'name_bn',
        'name_en',
        'description_en',
        'description_bn',
        'featured_image',
        'sold_amount',
        'vat_percent',
        'discount',
        'price_en',
        'price_bn',
        'quantity',
        'unit',
        'is_sold_out',
        'is_featured',
        'slug',
        'attribute',
        'cart_limit'

    ];
    protected $appends = [
        'count',
        'quantity_unit',
        'image_with_base_url',

    ];
    public $product = [];

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setCartLimitAttribute($value)
    {
        $this->attributes['cart_limit'] = $value < 1?null:$value;

//        if(!isset($value)) $this->attributes['cart_limit'] = null;
//
//        else $this->attributes['cart_limit'] = $value < 1?null:$value;
    }

    /****************************
     * Model Relation area
     *****************************/

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function productDetail()
    {
        return $this->hasOne(ProductDetail::Class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::Class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::Class);
    }

    public function topType()
    {
        return $this->belongsToMany('App\Models\TopType');
    }

    public function wishList()
    {
        return $this->belongsTo(WishList::class);
    }

    public function bundle()
    {
        return $this->hasOne(Bundle::class, 'product_id');
    }

    public function bundle_products()
    {
        return $this->hasMany(BundleProduct::class, 'parent_id');
    }

    public function product_sold()
    {
        return $this->hasMany(ProductSold::class);
    }

    public function product_reviews()
    {
        return $this->hasMany(ProductReview::class);
    }




    /****************************
     * Public Methods area
     *****************************/

    /***
     * Method to get data.
     * @param $data
     * @return
     */

    public function GetData($data)
    {
        $data['owner_id'] = Auth::user()->id;
        $data['brand_id'] = $this->GetBrandId($data['brand_id']);
        $data['is_sold_out'] = $this->GetCheckBoxValue($data,'is_sold_out');
        if (isset($data['featured_image'])) {
            $data['featured_image'] = $this->UploadImage($data['featured_image'], 'products');

        }
        return $data;
    }

    public function GetProducts($id)
    {

        return TopType::with('products')->where('products.is_deleted','=',0)->find($id);

    }
    public function ProductsGetBySearchKeywords($keywords)
    {

        return Product::query()
            ->where('is_deleted', '=',0)
            ->whereLike(['name_en', 'name_bn'], $keywords)
            ->paginate(50);


    }

    public function ManageSearchKeywords($keywords)
    {
        $searchService = new  SearchService();
        $searchService->Keyword($keywords);
    }
    public function GetProductByCategory($id)
    {
        $product = Category::with('product')->find($id);

        return $product;
    }

    public function GetProductByBrand($id)
    {
        $product = Brand::with('products')->find($id);

        return $product;

    }

    public function GetProductDetail($slug)
    {
       //return Product::with('category', 'productImages', 'productReviews')->find($id);
        return Product::with('category', 'productImages', 'productReviews')->where('slug',$slug)->first();
    }

    public static function all($keys = null)
    {
        return Product::where('is_deleted', 0)->get();
    }
    public static function deletedProducts($keys = null)
    {
        return Product::where('is_deleted', 1)->get();
    }

    public static function SoftDelete($keys = null)
    {
        return Product::where('id', $keys)->update(['is_deleted' => 1]);
    }
    public function GetDiscountedProducts()
    {
        return Product::where('discount','!=',null) ->where('is_deleted', 0)->get();
    }

    public function GetFeaturedProducts()
    {
        return Product::where('is_featured','=',1) ->where('is_deleted', 0)->get();
    }
    private function ImageUpload($data)
    {
        if (isset($data['featured_image'])) {
            $this->category['featured_image'] = $this->UploadImage($data['featured_image'], 'products');

        }

    }

    private function GetBrandId($brandId)
    {
        return $brandId=="NULL"?NULL:$brandId;

    }
    public function MarkUnMarkFeatured($id)
    {
        $product = Product::find($id);
        $status = ($product->is_featured==1?0:1);

        return $product->update(['is_featured'=>$status]);
    }
    public function Restore($id)
    {
        return Product::where('id', $id)->update(['is_deleted' => 0]);
    }

    /****************************
     * Accessor Methods area
     *****************************/

    public function getCountAttribute()
    {
        return 0;
    }

    public function getImageWithBaseUrlAttribute() {
        return url('/') .'/'. $this->featured_image;
    }

    public function getQuantityUnitAttribute()
    {
        if(!$this->quantity) return false;
        if(!$this->unit) return false;
        return "{$this->quantity} {$this->unit}";
    }


}
