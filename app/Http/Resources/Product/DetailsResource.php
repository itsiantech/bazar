<?php

namespace App\Http\Resources\Product;

use App\Traits\ResourceProductDetails;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailsResource extends JsonResource
{
    use ResourceProductDetails;

    public function toArray($request)
    {
        return $this->getDefaultResource();
    }
}
