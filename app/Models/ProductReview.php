<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'product_id',
        'user_id',
        'message',
        'rating',
    ];

    /****************************
     * Model Relation area
     *****************************/

    public function product()
    {
        return $this->belongsTo(  Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        return $data;
    }

    /****************************
     * Public Methods area
     *****************************/
}
