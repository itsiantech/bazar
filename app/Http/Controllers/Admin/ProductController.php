<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductInsertRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private  $moduleName="Product";
    private $singularVariableName = 'product';
    private $pluralVariableName = 'products';
    private $globalObject;

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Product();
    }
    public function SlugUpdate()
    {
        $products = Product::where('slug',null)->get();
        $this->authorize('viewAny', Product::class);
        foreach ($products as $product)
        {
            $title = $product->name_en;
            $plainText = preg_replace('/[^A-Za-z0-9]/',' ',$title);
            $slug = preg_replace('/[[:space:]]+/','-',$plainText);
             if ($this->UpdateSlug($product,$slug)==1)
             {
                continue;
             }
            continue;
        }
        $this->retrievedDataList =$products;

        return view('admin.'.$this->pluralVariableName.'.index',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }
    public function UpdateSlug($product,$slug)
    {
        try{
            if($product->update(['slug'=>$slug]))
            {
               return 1;
            }
        }
        catch (QueryException $ex)
        {
            try {
                if ($product->update(['slug' => $slug . '-' . $product->quantity . $product->unit])) {
                    return 1;
                }
            }
            catch (QueryException $ex) {
                if ($product->update(['slug' => $slug . '-' . $product->quantity . $product->unit.rand(0,1)])) {
                    return 1;
                }
            }
        }
        return 0;
    }
    public function Index()
    {
        $this->authorize('viewAny', Product::class);

        $this->retrievedDataList =$this->globalObject->all();

        return view('admin.'.$this->pluralVariableName.'.index',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }
    public function DeletedProducts()
    {
        $this->retrievedDataList =$this->globalObject->deletedProducts();

        return view('admin.'.$this->pluralVariableName.'.deleted',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }
    public function Create()
    {
        $this->authorize('create', Product::class);

        return view('admin.'.$this->pluralVariableName.'.create',[
            'categories'=>Category::all(),
            'brands'=>Brand::all()
        ]);
    }

    public function Edit($id)
    {
        $data = $this->globalObject->findOrFail($id);

        $this->authorize('create', $data);

        return view('admin.'.$this->pluralVariableName.'.edit',[
            $this->singularVariableName=>$data,
            'categories'=>Category::all(),
            'brands'=>Brand::all()
        ]);
    }

    public function Store(ProductInsertRequest $request)
    {

        $this->authorize('create', Product::class);

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

    // public function Update(ProductUpdateRequest $request)
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
        $data = $this->globalObject->findOrFail($id);

        $this->authorize('delete', $data);

        $this->globalObject->SoftDelete($id);

        return redirect()->back()->with(['success'=>$this->moduleName."  deleted successfully"]);

    }

    public function Restore($id)
    {
        try{
            if ($this->globalObject->Restore($id)){
                return redirect()->back()->with(['success'=>$this->moduleName."  deleted successfully"]);
            }
        }
        catch (QueryException $exception){
            return redirect()->back()->with(['error'=>$exception->getMessage()]);

        }
        return redirect()->back()->with(['error'=>"Unable to handle this request !"]);

    }
    public function Featured($id)
    {
        try{
            if ($this->globalObject->MarkUnMarkFeatured($id)){
                return redirect()->back()->with(['success'=>$this->moduleName."  added to featured list successfully"]);
            }
        }
        catch (QueryException $exception){
            return redirect()->back()->with(['error'=>$exception->getMessage()]);

        }
        return redirect()->back()->with(['error'=>"Unable to handle this request !"]);

    }


}
