<?php


namespace App\Traits;


use App\Http\Resources\Product\CategoryResource;
use App\Http\Resources\Product\PhotoResource;
use App\Http\Resources\Product\ReviewResource;

trait ResourceProductDetails
{
    public function getDefaultResource()
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
            'cart_limit' => $this->cart_limit,
            'discount' => $this->discount,
            'description' => [
                'en' => $this->description_en,
                'bn' => $this->description_bn
            ],
            'image' => $this->image_with_base_url,
            'images' => PhotoResource::collection($this->productImages),
            'category' => new CategoryResource($this->category),
            'reviews' => ReviewResource::collection($this->productReviews),
            'count' => $this->count,
        ];
    }


    public function getTopSoldProductDetailsResource()
    {
        $resource = $this->getDefaultResource();

        $resource['sold'] = $this->sold;

        return $resource;
    }

    public function getTopRatedProductDetailsResource()
    {
        $resource = $this->getDefaultResource();

        $resource['rating'] = $this->rating;

        return $resource;
    }


}
