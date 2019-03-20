<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $title = "Tambah Permission";
        $action = 'permissions';
        return view('permissions.form', compact('roles', 'title', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);

        $permission = new Permission;
        $permission->name = $request->name;
        $permission->save();

        if ($request->has('role')) {
            $permission->syncRoles($request->role);
        }

        return redirect('permissions')->with('status', 'Permission berhasil ditambah');
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
        $roles = Role::all();
        $permission = Permission::find($id);
        $title = 'Edit Permission';
        $method = 'PATCH';
        $action = 'permissions/' . $id;
        return view('permissions.form', compact('roles', 'permission', 'title', 'method', 'action'));
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
        $this->validation($request);

        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->save();

        if ($request->has('role')) {
            $permission->syncRoles($request->role);
        }

        return redirect('permissions')->with('status', 'Permission berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::find($id)->delete();
        return $id;
    }

    public function validation($request)
    {
        $rules = [
            'name' => 'required|max:100'
        ];
        $messages = [
            'name.required' => 'Nama Permission wajib diisi',
            'name.max' => 'Nama Permission maksimal adalah 100'
        ];
        $this->validate($request, $rules, $messages);
    }
}
