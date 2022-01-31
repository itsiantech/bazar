<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\SyncRoleRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\RoleManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::where('type', 'admin')->get();

        return view('admin.employee.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EmployeeRequest $request)
    {
        $this->authorize('create', User::class);

        $form_data = $request->validated();

        $form_data['type'] = 'admin';

        $form_data['password'] = Hash::make($form_data['password']);

        User::create($form_data);

        return redirect()->route('employee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('create', $user);

        return view('admin.employee.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('create', $user);

        return view('admin.employee.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(EmployeeRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('create', $user);

        $form_data = $request->validated();

        $form_data['type'] = 'admin';

        $form_data['password'] = Hash::make($form_data['password']);

        $user->update($form_data);

        return redirect(route('employee.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // abort(403, 'Temporary Disabled to delete');

        // $this->authorize('delete', $user);

        $user->delete();

        return redirect(route('employee.index'));
    }


    public function assign_role(User $user)
    {
        $roles = Role::pluck('name','id')->all();

        return view('admin.employee.assign_role',[
            'roles' => $roles,
            'user' => $user,
        ]);

    }

    public function sync_role(SyncRoleRequest $request, User $user)
    {
        return (new RoleManagement())->SyncRole($user, $request, 'employee.index');
    }

}
