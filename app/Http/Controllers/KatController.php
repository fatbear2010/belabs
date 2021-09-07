<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('check-jabatan');
        $queryBuilder = Kategori::All(); 
        return view('admin.kategori.index',compact('queryBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('check-jabatan');
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('check-jabatan');
        $data= new Kategori();
        $data->nama=$request->get('txtName');
        $data->save();
        return redirect()->route('kategori.index')->with('status','Category is added');
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
        $this->authorize('check-jabatan');
       // dd($id);
        $data =Kategori::find($id);
       // dd($data) ;
        //$data =$id;

        //dd($data);
        return view('admin.kategori.edit',compact('data'));
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
        $this->authorize('check-jabatan');
        $category = Kategori::find($id);
        // dd($category);
        $category->nama=$request->get('txtName');
        $category->save();
        return redirect()->route('kategori.index')->with('status','Category data is changed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $this->authorize('check-jabatan');
            $category = Kategori::find($id);
            //dd($category);
            $category->delete();
            return redirect()->route('kategori.index')->with('status','Data Category sudah dihapus');
 
        }
        catch(\PDOException $e)
        {
            $msg="Data Gagal dihapus. pastikan data child sudah hilang atau tidak berhubungan";
 
            return redirect()->route('category.index')->with('error',$msg);
        }
    }
}
