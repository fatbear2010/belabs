<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Models\Lab;
use App\Models\User;



class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $user = User::where('jabatan','<>','1')->get();
        return view('admin.lab.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $laboran =$request->get('laboran');
       
        $data = new Lab();
        $data->idlab = $request->get('txtID');
        
        $data->namaLab = $request->get('txtName');
        $data->lokasi = $request->get('txtLokasi');
        $data->fakultas = $request->get('txtFakultas');

        $data->save();
        
        foreach($laboran as $u)
        {
            $userlab = explode(',', $u);

            $data->users()->attach($userlab[0],["keterangan"=>$userlab[1]]);
            
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
        $data = Lab::find($id);
        // dd($data) ;
        //$data =$id;

        //dd($data);
        return view('admin.lab.edit', compact('data'));
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
        $lab = Lab::find($id);
        // dd($category);
        
        $lab->namaLab = $request->get('txtName');
        $lab->lokasi = $request->get('txtLokasi');
        $lab->fakultas = $request->get('txtFakultas');

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
}
