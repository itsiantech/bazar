<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    private $globalObject ;
    private  $moduleName="Slider";
    private $singularVariableName = 'slider';
    private $pluralVariableName = 'sliders';

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Slider();
    }

    public function Index()
    {
        $this->authorize('viewAny', Slider::class);

        $this->retrievedDataList=$this->globalObject->all();

        return view('admin.'.$this->pluralVariableName.'.index',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }

    public function Create()
    {
        $this->authorize('create', Slider::class);

        $this->retrievedDataList=$this->globalObject->all();
        return view('admin.'.$this->pluralVariableName.'.create',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }

    public function Edit($id)
    {
        $slider = $this->globalObject->findOrFail($id);
        // $slider = Slider::findOrFail($id);

        $this->authorize('update', $slider);

        return view('admin.'.$this->pluralVariableName.'.edit',[
            $this->singularVariableName=> $slider,
            $this->pluralVariableName=>$this->globalObject->all()
        ]);
    }

    public function Store(Request $request)
    {
        //dd($request->validated());
        $this->authorize('create', Slider::class);

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

        $slider = Slider::findOrFail($id);

        $this->authorize('delete', $slider);


        try{
            $slider->delete();
            return redirect()->back()->with(['success'=>$this->moduleName."  deleted successfully"]);
        }
        catch (QueryException $exception){
            return redirect()->back()->with(['error'=>$exception->getMessage()]);

        }
        return redirect()->back()->with(['error'=>"Unable to handle this request !"]);

    }
}
