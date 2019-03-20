<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
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
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah User";
        $action = 'users';
        return view('users.form', compact('title', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->password == $request->password_confirmation) {
            $data = $request->all();
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => \Hash::make($data['password']),
            ]);
            return redirect('users')->with('status', 'User berhasil diinput');
        } else {
            return redirect()->back()->with('error', 'Password tidak match');
        }
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
        User::find($id)->delete();
        return $id;
    }

    public function roles($id)
    {
        $user = User::find($id);
        $title = 'Edit User Roles';
        $action = 'users/' . $id . '/updateroles';
        $roles = Role::all();
        return view('users.roles', compact('user', 'title', 'action', 'roles'));
    }

    public function updateroles(Request $request, $id)
    {
        $user = User::find($id);
        if ($request->has('role')) {
            $user->syncRoles($request->role);
        }

        return redirect('users')->with('status', 'Role berhasil diupdate untuk user');
    }
}
