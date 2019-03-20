<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data;
use Spatie\Permission\Traits\HasPermissions;

class DataController extends Controller
{
    use HasPermissions;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->forgetCachedPermissions();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->hasPermissionTo('data.read')) {
            $datas = Data::all();
            return view('data.index', compact('datas'));
        } else {
            abort('403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Data';
        $action = 'data';
        return view('data.form', compact('title', 'action'));
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

        $data = $request->except('_token');
        Data::insert($data);

        return redirect('data')->with('status', 'Data berhasil ditambah');
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
        if (\Auth::user()->hasPermissionTo('data.update')) {
            $data = Data::find($id);
            $title = 'Ubah Data';
            $method = 'PATCH';
            $action = 'data/' . $id;
            return view('data.form', compact('data', 'title', 'method', 'action'));
        } else {
            abort('403');
        }
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
        if (\Auth::user()->hasPermissionTo('data.update')) {
            $data = Data::find($id);
            $data->name = $request->name;
            $data->price = $request->price;
            $data->save();

            return redirect('data')->with('status', 'Data berhasil diubah');
        } else {
            abort('403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->hasPermissionTo('data.delete')) {
            Data::find($id)->delete();
            return $id;
        } else {
            abort('403');
        }
    }

    public function validation($request)
    {
        $rules = [
            'name' => 'required|max:55',
            'price' => 'required|numeric'
        ];
        $messages = [
            'name.required' => 'Nama Data wajib diisi',
            'name.max' => 'Nama Data maksimal adalah 55',
            'price.numeric' => 'Harga harus berupa angka'
        ];
        $this->validate($request, $rules, $messages);
    }
}
