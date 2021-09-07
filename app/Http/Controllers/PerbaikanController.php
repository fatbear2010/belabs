<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BarangDetail;
use Illuminate\Http\Request;
use App\Models\Perbaikan;


class PerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('check-jabatan');
        $queryBuilder = Perbaikan::All();
        //dd($queryBuilder);
        $barangdetail = BarangDetail::All();
        return view('admin.perbaikan.index',compact('queryBuilder','barangdetail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('check-jabatan');
        $perb = Perbaikan::All();
        $bDetail = BarangDetail::All();
        return view('admin.perbaikan.create',compact('perb','bDetail'));
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
        $data= new Perbaikan();
        $data->idperbaikan = $request->get('txtID');
        $data->mulai=$request->get('txtMulai');
        $data->selesai=$request->get('txtSelesai');
        $data->keterangan=$request->get('txtKet');
        $data->barang=$request->get('comboKat');

        //dd( $data->kategori);
        $data->save();
        return redirect()->route('perbaikan.index')->with('status','Perbaikan sudah ditambahkan');
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
        $data =Perbaikan::find($id);
        //dd($data);
        $bar = BarangDetail::All();

        return view('admin.perbaikan.edit',compact('data','bar'));
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
        $perb = Perbaikan::find($id);
        // dd($category);
        $perb->idperbaikan = $perb->idperbaikan;
        $perb->mulai=$request->get('txtMulai');
        $perb->selesai=$request->get('txtSelesai');
        $perb->keterangan=$request->get('txtKet');
        $perb->barang=$request->get('comboKat');

        //dd($request->get('comboKat'));


        $perb->save();
        return redirect()->route('perbaikan.index')->with('status','Data Perbaikan Sudah diubah');
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
            $perb = Perbaikan::find($id);
            //dd($category);
            $perb->delete();
            return redirect()->route('perbaikan.index')->with('status','Data Perbaikan Sudah dihapus');
 
        }
        catch(\PDOException $e)
        {
            $msg="Data Gagal dihapus. pastikan data child sudah hilang atau tidak berhubungan";
 
            return redirect()->route('perbaikan.index')->with('error',$msg);
        }
    }
}
