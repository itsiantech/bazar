<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'en'=>$this->name_en,
            'bn'=>$this->name_bn,
            'icon'=>$this->icon,
            'banner' => $this->image
        ];
    }
}
