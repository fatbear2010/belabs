<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Models\Lab;
use App\Models\User;
use App\Models\Fakultas;
use App\Models\Sesi;


use Illuminate\Support\Facades\DB;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('check-jabatan');
        $queryBuilder = Lab::All();
        return view('admin.lab.index', compact('queryBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('check-jabatan');
        $user = User::where('jabatan','<>','1')->get();
        $fak = Fakultas::All();
        return view('admin.lab.create',compact('user','fak'));
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
        $laboran =$request->get('laboran');
        //dd($request->get('laboran'));
       
        $data = new Lab();
        $data->idlab = $request->get('txtID');
        
        $data->namaLab = $request->get('txtName');
        $data->lokasi = $request->get('txtLokasi');
        $data->fakultas = $request->get('comboFak');

        $data->save();
        
        foreach($laboran as $u)
        {
            $userlab = explode(',', $u);
            
            $query = DB::table('laboran')->insert(['lab'=>$request->get('txtID'),'user'=>$userlab[0],'keterangan'=>$userlab[1]]);
            // $data->users()->attach($userlab[0],["keterangan"=>$userlab[1]]);
            
        }
        //dd($data);
        return redirect()->route('lab.index')->with('status', 'Lab Sudah Ditambahkan');
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
        $data = Lab::find($id);
        $fak = Fakultas::All();
        // dd($data) ;
        //$data =$id;

        //dd($data);
        return view('admin.lab.edit', compact('data','fak'));
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
        $lab = Lab::find($id);
        // dd($category);
        
        $lab->namaLab = $request->get('txtName');
        $lab->lokasi = $request->get('txtLokasi');
        $lab->fakultas = $request->get('comboFak');

        $lab->save();
        return redirect()->route('lab.index')->with('status', 'Data Lab Sudah dihapus');
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
            $lab = Lab::find($id);
            //dd($category);
            $lab->delete();
            return redirect()->route('lab.index')->with('status', 'Data Lab sudah dihapus');
        } catch (\PDOException $e) {
            $msg = "Data Gagal dihapus. pastikan data child sudah hilang atau tidak berhubungan";

            return redirect()->route('lab.index')->with('error', $msg);
        }
    }
    public function showlaboran()
    {
        $arr = $_POST['lab'];
        $table = "";
        foreach ($arr as $a) {
            $user = User::find($a[0]);
            $table .= "<tr><td>$a[0]</td><td>$user->nama</td><td>$a[1]</td><td><button type=button onclick=removelaboran($a[0])><i class='ni ni-fat-remove'></i></button></td></tr><input type='hidden' name='laboran[]' value='$a[0],$a[1]'>";
        }
        return response()->json(array('status' => 'oke', 'msg' => $table), 200);
    }


    public function sesiPenggunaan($id)
    {
        $this->authorize('check-jabatan');
        $data = Lab::find($id);
        $sesi = Sesi::All();
        return view('admin.lab.penggunaan', compact('sesi','data'));
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
            $query = DB::table('rutin')->insert(['hari'=>$sesiL[4],'jamMulai'=>$sesiL[2],'jamSelesai'=>$sesiL[3],'idlab'=>$sesiL[5],'hariint'=>$sesiL[0]]);
            // $data->users()->attach($userlab[0],["keterangan"=>$userlab[1]]);
            
        }
        
        return redirect()->route('lab.index')->with('status', 'Barang Detail Waktu Penggunaan Berhasil');
    }

    public function blockSesi($id)
    {
        $this->authorize('check-jabatan');
        $data = Lab::find($id);
        $sesi = Sesi::All();
        return view('admin.lab.block', compact('sesi','data'));
    }

    public function showblock()
    {
        $arr = $_POST['sesi'];
        $table = "";
        foreach ($arr as $a) {
            
            $sesi = Sesi::find($a[1]);
            $table .= "<tr><td>$a[0]</td><td>$sesi->mulai</td><td>$sesi->selesai</td><td>$a[5]</td><td><button type=button onclick=removeSesi($a[1])><i class='ni ni-fat-remove'></i></button></td></tr><input type='hidden' name='sesi[]' value='$a[0],$a[1],$a[2],$a[3],$a[4],$a[5]'>";
        }
        return response()->json(array('status' => 'oke', 'msg' => $table), 200);
    }
    public function storeblock(Request $request)
    {
        $this->authorize('check-jabatan');
        $sesi =$request->get('sesi');
       // dd($sesi);
        foreach($sesi as $u)
        {
            $sesiL = explode(',', $u);
            //dd($sesiL);
            //dd($sesiL[5]);
            $query = DB::table('block')->insert(['tanggal'=>$sesiL[0],'mulai'=>$sesiL[2],'selesai'=>$sesiL[3],'idlab'=>$sesiL[4],'keterangan'=>$sesiL[5]]);
            // $data->users()->attach($userlab[0],["keterangan"=>$userlab[1]]);
            
        }
        
        return redirect()->route('barangdetail.index')->with('status', 'Lab Block Waktu Penggunaan Berhasil Ditambahkan');
    }
}
