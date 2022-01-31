<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WishList extends Model
{
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'user_id',
        'product_id'
    ];

    /****************************
     * Model Relation area
     *****************************/

    public function user()
    {
        return $this->belongsTo(  User::class, 'user_id');
    }
    public function products()
    {
        return $this->belongsTo(  Product::class, 'product_id');
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
        $data['user_id'] = Auth::user()->id;
        return $data;
    }

    /****************************
     * Public Methods area
     *****************************/

    public function GetWishListByUserId($userId)
    {
        return WishList::with('products')->where('user_id',$userId)->get();
    }

    public function CheckWishList($userId,$productId)
    {
        $product = WishList::where('user_id',$userId)->where('product_id',$productId)->first();
        if ($product)
        {
            return true;
        }
        return false;
    }

    public function RemoveItem($userId,$productId)
    {
        $product = WishList::where('user_id',$userId)->where('product_id',$productId)->delete();
        if ($product)
        {
            return true;
        }
        return false;
    }
}
