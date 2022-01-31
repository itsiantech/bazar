<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catgories\CategoryInsertRequest;
use App\Http\Requests\Catgories\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $globalObject;
    private $moduleName = "Category";
    private $singularVariableName = 'category';
    private $pluralVariableName = 'categories';

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {

        $this->globalObject = new Category();
    }

    public function Index()
    {
        $this->authorize('create', $this->globalObject);

        $this->retrievedDataList = $this->globalObject->all();
        //dd('test');

        return view('admin.' . $this->pluralVariableName . '.index', [
            $this->pluralVariableName => $this->retrievedDataList,
            'parents' => $this->globalObject->ParentCategories()
        ]);
    }

    public function Create()
    {
        $this->authorize('create', $this->globalObject);

        $this->retrievedDataList = $this->globalObject->all();
        return view('admin.' . $this->pluralVariableName . '.create', [
            $this->pluralVariableName => $this->retrievedDataList
        ]);
    }

    public function Edit($id)
    {

        return view('admin.' . $this->pluralVariableName . '.edit', [
            $this->singularVariableName => $this->globalObject->findOrFail($id),
            $this->pluralVariableName => $this->globalObject->all()
        ]);
    }

    public function Store(CategoryInsertRequest $request)
    {
        $this->authorize('create', $this->globalObject);
        //dd($request->validated());
        try {
            if ($this->globalObject->create($this->globalObject->GetData($request->all()))) {
                return redirect()->back()->with(['success' => $this->moduleName . " created successfully"]);
            }
            return redirect()->back()->with(['error' => "Unable to handle this request !"]);
        } catch (QueryException $ex) {
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }

    }

    public function Update(CategoryUpdateRequest $request)
    {
        $oldData = $this->globalObject->findOrFail($request->id);
//        dd($request->all());
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
        $this->authorize('create', $this->globalObject->findOrFail($id));
        // abort(403, 'Temporary Disabled to delete');

        try {
            if ($this->globalObject->destroy($id)) {
                return redirect()->back()->with(['success' => $this->moduleName . "  deleted successfully"]);
            }
        } catch (QueryException $exception) {
            return redirect()->back()->with(['error' => $exception->getMessage()]);

        }
        return redirect()->back()->with(['error' => "Unable to handle this request !"]);

    }


    public function UpdateOrder(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));

            foreach ($arr as $sortOrder => $id) {
                $menu = Category::find($id);
                $menu->priority = $sortOrder;
                $menu->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }
}
