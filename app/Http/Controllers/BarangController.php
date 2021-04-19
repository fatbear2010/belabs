<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $queryBuilder = Barang::All(); 
        $kat = Kategori::All();
        return view('admin.barang.index',compact('queryBuilder','kat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Kategori::All();
        
        return view('admin.barang.create',compact('cat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data= new Barang();
        //$cat = Kategori::find($request->get('comboKat'));
        

        // $file =$request->file('logo');
        // $imgFolder='img';
        // $imgFile=time()."_".$file->getClientOriginalName();
        // $file->move($imgFolder,$imgFile);
        // $data->url=$imgFile;
        $data->idbarang=$request->get('txtID');
        $data->nama=$request->get('txtNama');
        $data->kategori=$request->get('comboKat');
        //dd( $data->kategori);
        $data->save();
        return redirect()->route('barang.index')->with('status','Barang is added');
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
        $data =Barang::find($id);
        $cat = Kategori::All();

        return view('admin.barang.edit',compact('data','cat'));
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
        $barang = Barang::find($id);
        // dd($category);
        $barang->idbarang = $barang->idbarang;
        $barang->nama=$request->get('txtNama');
        //dd($request->get('comboKat'));

        $barang->kategori=$request->get('comboKat');

        $barang->save();
        return redirect()->route('barang.index')->with('status','Barang data is changed');
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
            $barang = Barang::find($id);
            //dd($category);
            $barang->delete();
            return redirect()->route('barang.index')->with('status','Data Barang sudah dihapus');
 
        }
        catch(\PDOException $e)
        {
            $msg="Data Gagal dihapus. pastikan data child sudah hilang atau tidak berhubungan";
 
            return redirect()->route('barang.index')->with('error',$msg);
        }
    }
}
