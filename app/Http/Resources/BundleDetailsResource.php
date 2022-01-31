<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BundleDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => [
                'en' => $this->name_en,
                'bn' => $this->name_bn,
            ],
            'unit' => $this->quantity_unit,
            'price' => [
                'en' => $this->price_en,
                'bn' => $this->price_bn
            ],
            'quantity' => $this->quantity,
            'image' => $this->image_with_base_url
        ];
    }
}
