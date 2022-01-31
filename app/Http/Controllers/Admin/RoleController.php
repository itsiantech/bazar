<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    private  $moduleName="role";
    private $singularVariableName = 'role';
    private $pluralVariableName = 'roles';
    private $globalObject;

    private $retrievedDataList;
    private $singleData;



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Role::class);
        $permissions = Permission::pluck('name','id')->all();
        return view('admin.'.$this->pluralVariableName.'.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $form_data = $request->validated();

        $role = Role::create($form_data);

        $role->givePermissionTo($form_data['permission_id']);

        return redirect()->back()->with(['success'=> $this->moduleName." created successfully"]);
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

        return redirect()->route('role.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        $role = Role::findOrFail($id);

        $this->authorize('update', $role);

        $this->authorize('update', $role);

        $role->update($request->validated());

        return redirect($this->singularVariableName.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $this->authorize('delete', $role);

        $role->delete();

        return redirect()->route('role.index');
    }
}
