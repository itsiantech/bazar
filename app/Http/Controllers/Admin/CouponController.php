<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private $globalObject ;
    private  $moduleName="Coupon";
    private $singularVariableName = 'coupon';
    private $pluralVariableName = 'coupons';

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Coupon();
    }

    public function Index()
    {
        $this->authorize('viewAny', Coupon::class);

        $this->retrievedDataList=$this->globalObject->all();

        return view('admin.'.$this->pluralVariableName.'.index',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }

    public function Create()
    {
        $this->authorize('create', Coupon::class);

        $this->retrievedDataList=$this->globalObject->all();
        return view('admin.'.$this->pluralVariableName.'.create',[
            $this->pluralVariableName=>$this->retrievedDataList
        ]);
    }

    public function Edit($id)
    {
        $coupon = $this->globalObject->findOrFail($id);

        $this->authorize('update', $coupon);

        return view('admin.'.$this->pluralVariableName.'.edit',[
            $this->singularVariableName=>$coupon,

        ]);
    }

    public function Store(Request $request)
    {
        $this->authorize('create', Coupon::class);

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
        try
        {
            $oldData = $this->globalObject->findOrFail($request->id);
            $couponStartedAt = $oldData->created_at->addDays(1);
            if(now()->gt($couponStartedAt)) abort(403, 'Coupon has already been started. You can not edit now.');

            $this->authorize('update', $oldData);
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
        $coupon = Coupon::findOrFail($id);
        $this->authorize('delete', $coupon);
        // abort(403, 'Temporary Disabled to delete');

        try{
            if ($coupon->destroy($id)){
                return redirect()->back()->with(['success'=>$this->moduleName."  deleted successfully"]);
            }
        }
        catch (QueryException $exception){
            return redirect()->back()->with(['error'=>$exception->getMessage()]);

        }
        return redirect()->back()->with(['error'=>"Unable to handle this request !"]);

    }
}
