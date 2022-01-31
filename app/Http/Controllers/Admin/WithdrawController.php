<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    private $globalObject;
    private $moduleName = "Withdraw";
    private $singularVariableName = 'withdraw';
    private $pluralVariableName = 'withdraws';

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Withdraw();
    }

    public function Index()
    {
        $this->retrievedDataList = $this->globalObject->all();

        return view('admin.' . $this->pluralVariableName . '.index', [
            $this->pluralVariableName => $this->retrievedDataList
        ]);
    }





    public function Update(Request $request)
    {
//        dd($request->all());
        try {
            $oldData = $this->globalObject->findOrFail($request->id);
            if ($oldData->update($this->globalObject->GetData($request->all()))) {
                return redirect()->back()->with(['success' => $this->moduleName . "  updated successfully"]);
            }
            return redirect()->back()->with(['error' => "Unable to update"]);

        } catch (QueryException $ex) {
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }

    }

    public function Delete($id)
    {
        try {
            if ($this->globalObject->destroy($id)) {
                return redirect()->back()->with(['success' => $this->moduleName . "  deleted successfully"]);
            }
        } catch (QueryException $exception) {
            return redirect()->back()->with(['error' => $exception->getMessage()]);

        }
        return redirect()->back()->with(['error' => "Unable to handle this request !"]);

    }

}
