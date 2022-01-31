<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginationResource extends ResourceCollection
{
    public static $wrap = 'items';

    protected $resourceClass;

    public function __construct($resource, $resourceClass)
    {
        parent::__construct($resource);

        $this->resourceClass = $resourceClass;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resourceClass::collection($this->collection);
    }
}
