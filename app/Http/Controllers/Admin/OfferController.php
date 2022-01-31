<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    private  $moduleName="Offer";
    private $singularVariableName = 'offer';
    private $pluralVariableName = 'offers';
    private $globalObject;

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Offer();
    }

    public function Index()
    {
        $this->retrievedDataList =$this->globalObject->all();

        return view('admin.'.$this->pluralVariableName.'.index',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }

    public function Create()
    {
        return view('admin.'.$this->pluralVariableName.'.create',[

        ]);
    }

    public function Edit($id)
    {
        return view('admin.'.$this->pluralVariableName.'.edit',[
            $this->singularVariableName=>$this->globalObject->findOrFail($id)
        ]);
    }

    public function Store(Request $request)
    {
        try
        {
            if ($this->globalObject->create($this->globalObject->GetData($request->all())))
            {
                return redirect()->back()->with(['success'=> $this->moduleName." created successfully"]);
            }
        }
        catch (QueryException $ex)
        {
            return redirect()->back()->with(['error'=>$ex->getMessage()]);
        }
        return redirect()->back()->with(['error'=>"Unable to handle this request !"]);
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
