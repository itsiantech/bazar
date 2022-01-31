<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopType;
use App\Http\Resources\TopTypeResource;
use Illuminate\Support\Facades\DB;

class TopTypeController extends Controller
{
    private $globalObject ;

    function __construct()
    {
        $this->globalObject = new TopType();
    }
    public function TopTypes() {
        // return "from top-types";
        // return response($this->globalObject::orderBy('priority', 'asc')->get(['id', 'name']),200);
        $datas = DB::table('top_types')->get(); // it will get the entire table

        // $types = TopTypes::all();
        return  $datas;
        // return response($this->globalObject::orderBy('priority', 'asc')->get(['id', 'name']),200);
    }
    public function Products($id)
    {
        return response(new TopTypeResource($this->globalObject->TopProducts($id)),200);
    }
}
