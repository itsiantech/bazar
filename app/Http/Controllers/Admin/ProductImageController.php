<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductImageController extends Controller
{
    private $globalObject ;
    private  $moduleName="ProductImage";
    private $singularVariableName = 'productImage';
    private $pluralVariableName = 'productImages';

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new ProductImage();
    }

    public function Index($id)
    {
        $this->retrievedDataList=$this->globalObject->GetImages($id);
       // dd($this->retrievedDataList->productImages);

        return view('admin.products.images',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }


    public function Store(Request $request)
    {
        //dd($request->validated());
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



    public function Delete($id)
    {
        $image = ProductImage::find($id);
        File::delete($image->image);
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
