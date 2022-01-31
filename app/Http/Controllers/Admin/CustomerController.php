<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Exports\UsersExportView;
use App\Http\Requests\SyncRoleRequest;
use App\Models\User;
use App\Services\RoleManagement;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class CustomerController extends Controller
{
    private  $moduleName="customer";
    private $singularVariableName = 'customer';
    private $pluralVariableName = 'customers';
    private $globalObject;

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new User();
    }

    public function index()
    {
        $this->authorize('viewAny', $this->globalObject);

        $this->retrievedDataList = $this->globalObject->with('roles')->where('type','customer')->latest()->get();
        return view('admin.'.$this->pluralVariableName.'.index',[
            $this->pluralVariableName => $this->retrievedDataList
        ]);
    }

    public function getDateFilteredCustomers(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date_format:Y-m-d',
            'end' => 'required|date_format:Y-m-d'
        ]);

        $start = Carbon::createFromFormat("!Y-m-d", request('start'));
        $end = Carbon::createFromFormat("!Y-m-d", request('end'));

        $this->retrievedDataList = User::where('type','customer')->whereBetween('created_at', [$start, $end])->orderBy('id', 'desc')->get();

        return view('admin.'.$this->pluralVariableName.'.index',[
            $this->pluralVariableName => $this->retrievedDataList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->globalObject->findOrFail($id);
        // abort(403, 'Temporary Disabled to delete');

        // $this->authorize('delete', $data);

        $data->delete();

        return redirect()->back()->with(['success'=>$this->moduleName."  deleted successfully"]);
    }

    public function assign_role(User $user)
    {
        $roles = Role::pluck('name','id')->all();

        return view('admin.'.$this->pluralVariableName.'.assign_role',[
            'roles' => $roles,
            'user' => $user,
        ]);

    }

    public function sync_role(SyncRoleRequest $request, User $user)
    {
        return (new RoleManagement())->SyncRole($user, $request, 'customer.index');
    }

    public function disable_customer($id)
    {
        $user = User::findOrFail($id);

        $user->update(['is_activated' => 0]);

        return redirect()->route('customer.index');
    }

    public function enable_customer($id)
    {
        $user = User::findOrFail($id);

        $user->update(['is_activated' => 1]);

        return redirect()->route('customer.index');
    }

//
//    public function export()
//    {
//        return Excel::download(new UsersExport, 'users.xlsx');
//    }

    public function export()
    {
        return Excel::download(new UsersExportView(), 'users.xlsx');
    }


}
