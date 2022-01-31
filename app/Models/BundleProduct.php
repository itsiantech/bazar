<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BundleProduct extends Model
{
    protected $guarded = ['id'];


    public function parentProduct()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    public function productDetails()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
