<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'color',
        'quantity',
        'size',
    ];

    /****************************
     * Model Relation area
     *****************************/

    public function product()
    {
        return $this->hasOne(  Product::class);
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
