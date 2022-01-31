<?php

namespace App\Models;

use App\Traits\CommonFunctions;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use CommonFunctions;
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'product_id',
        'image',
    ];

    /****************************
     * Model Relation area
     *****************************/

    public function product()
    {
        return $this->belongsTo(  Product::class);
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
        if (isset($data['image'])) {
            $data['image'] = $this->UploadImage($data['image'], 'products');

        }
        return $data;
    }

    public function GetImages($id)
    {
        return Product::with('productImages')->find($id);
    }

    /****************************
     * Public Methods area
     *****************************/
}
