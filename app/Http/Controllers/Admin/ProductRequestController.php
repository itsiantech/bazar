<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductRequestController extends Controller
{
    private $globalObject ;
    private  $moduleName="ProductRequest";
    private $singularVariableName = 'productRequest';
    private $pluralVariableName = 'productRequests';
    private $directoryName = 'product_requests';

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new ProductRequest();
    }
    public function Index()
    {
        $this->authorize('viewAny', $this->globalObject);
        $this->retrievedDataList=$this->globalObject->GetProductRequests();
        //dd($this->retrievedDataList=$this->globalObject->GetProductRequests());
        return view('admin.'.$this->directoryName.'.index',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }

    public function Create()
    {
        $this->authorize('create', $this->globalObject);
        $this->retrievedDataList=$this->globalObject->all();
        return view('admin.'.$this->directoryName.'.create',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }





    public function Update(Request $request)
    {
//        dd($request->all());
        try
        {
            $oldData = $this->globalObject->findOrFail($request->id);
            if ($oldData->update($this->globalObject->GetData($request->all())))
            {
                return redirect()->back()->with(['success'=>$this->moduleName."  updated successfully"]);
            }
            return redirect()->back()->with(['error'=>"Unable to update"]);

        }
        catch (QueryException $ex)
        {
            return redirect()->back()->with(['error'=>$ex->getMessage()]);
        }

    }

    public function Delete($id)
    {
        try{
            if ($this->globalObject->destroy($id)){
                return redirect()->back()->with(['success'=>$this->moduleName."  deleted successfully"]);
            }
        }
        catch (QueryException $exception){
            return redirect()->back()->with(['error'=>$exception->getMessage()]);

        }
        return redirect()->back()->with(['error'=>"Unable to handle this request !"]);

    }
}
