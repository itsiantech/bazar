<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationLocation;
use App\Models\Page;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private  $moduleName="Page";
    private $singularVariableName = 'page';
    private $pluralVariableName = 'pages';
    private $globalObject;

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Page();
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
            'navigations'=>NavigationLocation::all(),

        ]);
    }

    public function Edit($id)
    {
        return view('admin.'.$this->pluralVariableName.'.edit',[
            $this->singularVariableName=>$this->globalObject->findOrFail($id),
            'navigations'=>NavigationLocation::all(),

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
            if ($oldData->update($this->globalObject->UpdateData($request->all(), $oldData)))
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
       try
       {
           $page = Page::findOrFail($id);

           if($page->delete())
           {
               $page->RemoveImage($page->banner_image);
               return redirect()->back()->with(['success'=>$this->moduleName."  deleted successfully"]);
           }

       }catch (\Exception $e)
       {
           return redirect()->back()->with(['error'=>$e->getMessage()]);
       }

        return redirect()->back()->with(['error'=>"Unable to handle this request !"]);

    }
}
