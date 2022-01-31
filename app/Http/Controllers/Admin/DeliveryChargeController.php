<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryCharge;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DeliveryChargeController extends Controller
{
    private $moduleName = "DeliveryCharge";
    private $singularVariableName = 'deliveryCharge';
    private $pluralVariableName = 'delivery_charges';
    private $globalObject;

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new DeliveryCharge();
    }

    public function Index()
    {
        $this->authorize('create', $this->globalObject);

        $this->retrievedDataList = $this->globalObject->all();

        return view('admin.' . $this->pluralVariableName . '.index', [
            $this->pluralVariableName => $this->retrievedDataList
        ]);
    }

    public function Create()
    {
        $this->authorize('create', $this->globalObject);

        return view('admin.' . $this->pluralVariableName . '.create', [

        ]);
    }

    public function Edit($id)
    {
        $oldData = $this->globalObject->findOrFail($id);

        $this->authorize('create', $oldData);

        return view('admin.' . $this->pluralVariableName . '.edit', [
            $this->singularVariableName => $oldData,

        ]);
    }

    public function Store(Request $request)
    {
        $this->authorize('create', $this->globalObject);

        try {
            if ($this->globalObject->create($this->globalObject->GetData($request->all()))) {
                return redirect()->back()->with(['success' => $this->moduleName . " created successfully"]);
            }
        } catch (QueryException $ex) {
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
        return redirect()->back()->with(['error' => "Unable to handle this request !"]);
    }

    public function Update(Request $request)
    {
        $oldData = $this->globalObject->findOrFail($request->id);

        $this->authorize('create', $oldData);

        try {
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
        $data = $this->globalObject->findOrFail($id);
        // abort(403, 'Temporary Disabled to delete');

        $this->authorize('delete', $data);

        $data->delete();

        return redirect()->back()->with(['success'=>$this->moduleName."  deleted successfully"]);

    }
}
