<?php

namespace App\Http\Controllers;

use App\Models\BarangDetail;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Lab;
use App\Models\Sesi;

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
        $lab = Lab::All();
        $barang = Barang::All();
        return view('admin.barangdetail.create', compact( 'barang','lab'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $this->authorize('check-jabatan');
        $data= new BarangDetail();
        $data->idbarangDetail=$request->get('txtIDdetail');
        $data->idbarang=$request->get('comboBarang');
        $data->nama=$request->get('txtNama');
        $data->merk=$request->get('txtMerk');
        $data->kondisi=$request->get('txtKondisi');
        $data->perbaikan=$request->get('txtPerbaikan');
        $data->status=$request->get('txtStatus');
        $data->lab=$request->get('comboLab');
        $data->jumPakai=$request->get('txtJum1');
        $data->durasiPakai=$request->get('txtJum2');
        $data->wktPakai1=$request->get('txtWkt1');


        $data->save();
        return redirect()->route('barangdetail.index')->with('status','Barang Detail is added');
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
    public function sesiPenggunaan($id)
    {
        $this->authorize('check-jabatan');
        $data = BarangDetail::find($id);
        $sesi = Sesi::All();
        return view('admin.barangdetail.penggunaan', compact('sesi','data'));
    }

    public function showsesi()
    {
        $arr = $_POST['sesi'];
        $table = "";
        foreach ($arr as $a) {
            $sesi = Sesi::find($a[1]);
            $table .= "<tr><td>$a[4]</td><td>$sesi->mulai</td><td>$sesi->selesai</td><td><button type=button onclick=removeSesi($a[1])><i class='ni ni-fat-remove'></i></button></td></tr><input type='hidden' name='sesi[]' value='$a[0],$a[1],$a[2],$a[3],$a[4],$a[5]'>";
        }
        return response()->json(array('status' => 'oke', 'msg' => $table), 200);
    }
    public function storesesi(Request $request)
    {
        $this->authorize('check-jabatan');
        $sesi =$request->get('sesi');
       // dd($sesi);
        foreach($sesi as $u)
        {
            $sesiL = explode(',', $u);
            //dd($sesiL[5]);
            $query = DB::table('rutin')->insert(['hari'=>$sesiL[4],'jamMulai'=>$sesiL[2],'jamSelesai'=>$sesiL[3],'idbarangDetail'=>$sesiL[5],'hariint'=>$sesiL[0]]);
            // $data->users()->attach($userlab[0],["keterangan"=>$userlab[1]]);
            
        }
        
        return redirect()->route('barangdetail.index')->with('status', 'Barang Detail Waktu Penggunaan Berhasil');
    }

    
}
