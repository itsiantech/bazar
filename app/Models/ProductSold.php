<?php

namespace App\Models;

use App\Traits\ProductSoldTrait;
use Illuminate\Database\Eloquent\Model;

class ProductSold extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }



}


