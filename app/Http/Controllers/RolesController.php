<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
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
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        $title = "Tambah Role";
        $action = 'roles';
        return view('roles.form', compact('permissions', 'title', 'action'));
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

        $role = new Role;
        $role->name = $request->name;
        $role->save();

        if ($request->has('permission')) {
            $role->syncPermissions($request->permission);
        }

        return redirect('roles')->with('status', 'Role berhasil ditambah');
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
        $permissions = Permission::all();
        $role = Role::find($id);
        $title = 'Edit Role';
        $method = 'PATCH';
        $action = 'roles/' . $id;
        return view('roles.form', compact('permissions', 'title', 'role', 'method', 'action'));
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

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        if ($request->has('permission')) {
            $role->syncPermissions($request->permission);
        }

        return redirect('roles')->with('status', 'Role berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        return $id;
    }

    public function validation($request)
    {
        $rules = [
            'name' => 'required|max:15'
        ];
        $messages = [
            'name.required' => 'Nama Role wajib diisi',
            'name.max' => 'Nama Role maksimal adalah 15'
        ];
        $this->validate($request, $rules, $messages);
    }
}
