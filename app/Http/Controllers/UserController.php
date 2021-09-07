<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Jabatan;
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
        return view('admin.user.create', compact('jabatan'));
    }
    public function store(Request $request)
    {
        $this->authorize('check-jabatan');
        $data= new User();
        $data->id=$request->get('txtID');
        $data->nrpnpk=$request->get('txtNRP');
        $data->nama=$request->get('txtNama');
        $data->email=$request->get('txtEmail');
        
        $data->status=2;
        $data->password=hash::make($request->get('txtPassword'));
        $data->jabatan=$request->get('comboJabatan');
        


        $data->save();
        return redirect()->route('users.index')->with('status','User is added');
    }
    public function edit($id)
    {
        $this->authorize('check-jabatan');
        $jabatan = Jabatan::All();
        $data =User::find($id);
        return view('admin.user.edit',compact('data','jabatan'));
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
