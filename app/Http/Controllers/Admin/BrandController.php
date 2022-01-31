<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $globalObject ;
    private  $moduleName="Brand";
    private $singularVariableName = 'brand';
    private $pluralVariableName = 'brands';

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Brand();
    }

    public function Index()
    {
        $this->authorize('viewAny', $this->globalObject);

        $this->retrievedDataList=$this->globalObject->BrandsOrderByPriority();

        return view('admin.'.$this->pluralVariableName.'.index',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }

    public function Create()
    {
        $this->authorize('create', $this->globalObject);

        $this->retrievedDataList=$this->globalObject->all();
        return view('admin.'.$this->pluralVariableName.'.create',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }

    public function Edit($id)
    {
        $data = $this->globalObject->findOrFail($id);

        $this->authorize('update', $data);

        return view('admin.'.$this->pluralVariableName.'.edit',[
            $this->singularVariableName=>$data,
            $this->pluralVariableName=>$this->globalObject->all()
        ]);
    }

    public function Store(Request $request)
    {
        //dd($request->validated());
        $this->authorize('create', $this->globalObject);

        try
        {
            if ($this->globalObject->create($this->globalObject->GetData($request->all())))
            {
                return redirect()->back()->with(['success'=> $this->moduleName." created successfully"]);
            }
            return redirect()->back()->with(['error'=>"Unable to handle this request !"]);
        }
        catch (QueryException $ex)
        {
            return redirect()->back()->with(['error'=>$ex->getMessage()]);
        }

    }

    public function Update(Request $request)
    {
        $oldData = $this->globalObject->findOrFail($request->id);

        $this->authorize('update', $oldData);

        try
        {

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
        // abort(403, 'Temporary Disabled to delete');
        $this->authorize('delete', Brand::findOrFail($id));

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

    public function UpdateOrder(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));

            foreach ($arr as $sortOrder => $id) {
                $menu = Brand::find($id);
                $menu->priority = $sortOrder;
                $menu->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }
}
