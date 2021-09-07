<?php

namespace App\Http\Controllers;

use App\Models\BarangDetail;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Lab;
use DB;
use App\Models\Barang;


class BarangDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('check-jabatan');
        $queryBuilder = DB::table('barangDetail')->get();
        foreach($queryBuilder as $q )
        {
            $q->gambars = DB::table('gambar')->where('barang',$q->idbarangDetail)->get();
        }
        
       
       
        //dd($queryBuilder);
        $kat = Kategori::All();
        $lab = Lab::All();

        return view('admin.barangdetail.index',compact('queryBuilder','kat','lab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('check-jabatan');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $data = BarangDetail::find($id);
        $cat = Kategori::All();
        $lab = Lab::All();

        return view('admin.barangdetail.edit', compact('data', 'cat','lab'));
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
        $bd = BarangDetail::find($id);
        // dd($category);
        $bd->merk = $request->get('txtMerk');
        $bd->kondisi = $request->get('txtKondisi');
        $bd->perbaikan = $request->get('txtPerbaikan');
        $bd->status = $request->get('txtStatus');
        $bd->lab = $request->get('comboLab');
        $bd->jumPakai = $request->get('txtJum1');
        $bd->durasiPakai = $request->get('txtJum2');
        $bd->wktPakai1 = $request->get('txtWkt1');
       

        
        //dd($request->get('comboKat'));
        $bd->save();
        return redirect()->route('barangdetail.index')->with('status', 'Barang Detail data is changed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
