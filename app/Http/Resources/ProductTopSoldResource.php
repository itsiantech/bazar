<?php

namespace App\Http\Resources;

use App\Traits\ResourceProductDetails;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductTopSoldResource extends JsonResource
{
    use ResourceProductDetails;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->getTopSoldProductDetailsResource();
    }
}
