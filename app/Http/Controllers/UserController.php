<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Jabatan;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $this->authorize('check-jabatan');
        $queryBuilder = User::All();
        return view('admin.user.index', compact('queryBuilder'));
    }
    public function create()
    {
        $this->authorize('check-jabatan');
        $jabatan = Jabatan::All();
        $jurusan = Jurusan::All();

        return view('admin.user.create', compact('jabatan','jurusan'));
    }
    public function store(Request $request)
    {
        $this->authorize('check-jabatan');
        $data= new User();
       // $data->id=$request->get('txtID');
        $data->nrpnpk=$request->get('txtNRP');
        $data->nama=$request->get('txtNama');
        $data->email=$request->get('txtEmail');
        
        $data->status=2;
        //$data->password=hash::make($request->get('txtPassword'));
        //dd($request->get('comboJabatan'));
        $data->jabatan=$request->get('comboJabatan');
        $data->jurusan=$request->get('comboJurusan');
        //dd($data);
        $data->save();
        return redirect()->route('users.index')->with('status','User is added');
    }
    public function edit($id)
    {
        $this->authorize('check-jabatan');
        $jabatan = Jabatan::All();
        $data =User::find($id);
        
        return view('admin.user.edit', compact('jabatan','data'));
       
    }
    public function update(Request $request, $id)
    {
        $this->authorize('check-jabatan');
        $data = User::find($id);
        // dd($category); $data->id=$request->get('txtID');
        $data->nrpnpk=$request->get('txtNRP');
        $data->nama=$request->get('txtNama');
        $data->status=2;
        $data->jabatan=$request->get('comboJabatan');
       
        $data->save();
        return redirect()->route('users.index')->with('status','User data is changed');   
    }
}
