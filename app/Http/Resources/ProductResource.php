<?php

namespace App\Http\Resources;

use App\Models\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\PhotoResource;
use App\Http\Resources\Product\CategoryResource;
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => [
                'en' => $this->name_en,
                'bn' => $this->name_bn,
            ],
            'unit' => $this->quantity_unit,
            'price' => [
                'en' => $this->price_en,
                'bn' => $this->price_bn
            ],
            'discount' => $this->discount,
            'description' => [
                'en' => $this->description_en,
                'bn' => $this->description_bn
            ],
            'vat'=>[
                'percent'=>$this->vat_percent,
            ],
            'cart_limit' => $this->cart_limit,
            'sold_amount'=>$this->sold_amount,
            'is_sold_out'=>$this->is_sold_out,
            'image' => $this->image_with_base_url,
            'count' => $this->count,
            'attribute' => $this->attribute,
            'slug' => $this->slug
        ];
    }
}
