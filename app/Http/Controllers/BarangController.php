<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangDetail;
use App\Models\GambarBarang;
use App\Models\Kategori;
use App\Models\Lab;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('check-jabatan');
        $queryBuilder = Barang::All();

        //dd($queryBuilder);
        $kat = Kategori::All();
        $lab = Lab::All();

        return view('admin.barang.index', compact('queryBuilder', 'kat', 'lab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('check-jabatan');
        $cat = Kategori::All();
        $lab = Lab::All();

        return view('admin.barang.create', compact('cat', 'lab'));
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
        //$cat = Kategori::find($request->get('comboKat'));
        // $file =$request->file('logo');
        // $imgFolder='img';
        // $imgFile=time()."_".$file->getClientOriginalName();
        // $file->move($imgFolder,$imgFile);
        // $data->url=$imgFile;
        $data = new Barang();
        $data->idbarang = $request->get('txtID');
        $data->nama = $request->get('txtNama');
        $data->kategori = $request->get('comboKat');
        //dd( $data->kategori);

        $data->save();

        $arrayDataDetail[] = $request->get('txtIDDetail');
        $arrayDataDetail[] = $request->get('txtMerk');
        $arrayDataDetail[] = $request->get('txtKondisi');
        $arrayDataDetail[] = $request->get('txtPerbaikan');
        $arrayDataDetail[] = $request->get('txtStatus');
        $arrayDataDetail[] = $request->get('comboLab');
        $arrayDataDetail[] = $request->get('txtJum1');
        $arrayDataDetail[] = $request->get('txtJum2');
        $arrayDataDetail[] = $request->get('txtWkt1');
        $arrayDataDetail[] = $request->get('txtNamaDetil');
//dd($request->get('txtNamaDetil'));
        $jumlah = count($request->get('txtIDDetail'));
        for ($i = 0; $i < $jumlah; $i++) {
            $bd = new BarangDetail();
            $bd->idbarangDetail = $arrayDataDetail[0][$i];
            $bd->merk = $arrayDataDetail[1][$i];
            $bd->kondisi = $arrayDataDetail[2][$i];
            $bd->perbaikan = $arrayDataDetail[3][$i];
            $bd->status = $arrayDataDetail[4][$i];
            $bd->lab = $arrayDataDetail[5][$i];
            $bd->jumPakai = $arrayDataDetail[6][$i];
            $bd->durasiPakai = $arrayDataDetail[7][$i];
            $bd->wktPakai1 = $arrayDataDetail[8][$i];
            $bd->nama = $arrayDataDetail[9][$i];

            $bd->idbarang = $request->get('txtID');
            $bd->save();

            if ($i == 0) {
                if ($request->has('filefoto_')) {
                    $file = $request->file('filefoto_');
                    foreach ($file as $f) {
                        $foto = new GambarBarang();
                        $imgFolder = 'img';
                        $imgFile = time() . "_" . $f->getClientOriginalName();
                        $f->move($imgFolder, $imgFile);
                        $foto->namafile = $imgFile;
                        $foto->barang = $arrayDataDetail[0][$i];
                        $foto->save();
                    }
                }
            }
            else
            {
                if ($request->has('filefoto_'.$i)) {
                    $file = $request->file('filefoto_'.$i);
                    foreach ($file as $f) {
                        $foto = new GambarBarang();
                        $imgFolder = 'img';
                        $imgFile = time() . "_" . $f->getClientOriginalName();
                        $f->move($imgFolder, $imgFile);
                        $foto->namafile = $imgFile;
                        $foto->barang = $arrayDataDetail[0][$i];
                        $foto->save();
                    }
                }
            }
        }
        return redirect()->route('barang.index')->with('status', 'Barang sudah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('check-jabatan');
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
        $data = Barang::find($id);
        $cat = Kategori::All();

        return view('admin.barang.edit', compact('data', 'cat'));
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
        $barang = Barang::find($id);
        // dd($category);
        $barang->idbarang = $barang->idbarang;
        $barang->nama = $request->get('txtNama');
        //dd($request->get('comboKat'));

        $barang->kategori = $request->get('comboKat');

        $barang->save();
        return redirect()->route('barang.index')->with('status', 'Barang data is changed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->authorize('check-jabatan');
            $sqlsearchIdbarang = BarangDetail::where("idbarang",$id)->get();
            
            foreach($sqlsearchIdbarang as $s)
            { 
               
                $gambar = GambarBarang::where("barang",$s->idbarangDetail)->get();
                 $perbaikan =  Perbaikan::where("barang",$s->idbarangDetail)->get();
                foreach($gambar as $g)
                {
                    $g->delete();
                }
                foreach($perbaikan as $p)
                {
                    $p->delete();
                }
                $s->delete();
            }
            
           
            $barang = Barang::find($id);
            //dd($category);
            $barang->delete();
            return redirect()->route('barang.index')->with('status', 'Data Barang sudah dihapus');
        } catch (\PDOException $e) {
            $msg = "Data Gagal dihapus. pastikan data child sudah hilang atau tidak berhubungan";

            return redirect()->route('barang.index')->with('error', $msg);
        }
    }
}
