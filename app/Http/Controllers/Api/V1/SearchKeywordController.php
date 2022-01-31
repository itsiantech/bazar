<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SearchKeywordResource;
use App\Models\SearchKeyword;
use Illuminate\Http\Request;

class SearchKeywordController extends Controller
{
    private $globalObject ;

    function __construct()
    {
        $this->globalObject = new SearchKeyword();
    }
    public function SearchKeywords($kewords)
    {
        $data = $this->globalObject->GetSearchKeywords($kewords);
        return new PaginationResource($data, SearchKeywordResource::class);
//        return response( SearchKeywordResource::collection($this->globalObject->GetSearchKeywords($kewords))) ;
    }
}
