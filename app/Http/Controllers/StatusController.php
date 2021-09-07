<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Jabatan;
use App\Models\StatusJabatan;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('check-jabatan');
        $queryBuilder = Status::All(); 
        return view('admin.status.index',compact('queryBuilder'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('check-jabatan');
        $queryBuilder = Jabatan::All(); 

        return view('admin.status.create',compact('queryBuilder'));
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
        $jabatan = Jabatan::all();
       
        $data= new Status();
        $data->nama=$request->get('txtName');
        $data->kategori=$request->get('txtKat');
        $data->save();
        foreach($jabatan as $j)
        {
            if($request->get('check_'.$j->idjabatan))
            {
                $data->jabatans()->attach($j->idjabatan,["hakAkses"=>'1']);
            }
            else{
                $data->jabatans()->attach($j->idjabatan,["hakAkses"=>'0']);
            }
        }

        
        return redirect()->route('status.index')->with('status','Status is added');
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
        $data =Status::find($id);
        $queryBuilder = Jabatan::all();
        $statusjbtn = StatusJabatan::where('idstatus',$id)->get();
         return view('admin.status.edit',compact('data','queryBuilder','statusjbtn'));
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
        $jabatan = Jabatan::all();
        $status = Status::find($id);
        // dd($category);
        $status->nama=$request->get('txtName');
        $status->kategori=$request->get('txtKat');
        
        foreach($jabatan as $j)
        {
            if($request->get('check_'.$j->idjabatan))
            {
                $status->jabatans()->updateExistingPivot($j->idjabatan,["hakAkses"=>'1']);
            }
            else{
                $status->jabatans()->updateExistingPivot($j->idjabatan,["hakAkses"=>'0']);
            }
        }
        $status->save();
        
        return redirect()->route('status.index')->with('status','Status data is changed');
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
            $status = Status::find($id);
            $status->jabatans()->detach($id);
            //dd($category);
            $status->delete();
            return redirect()->route('status.index')->with('status','Data Category sudah dihapus');
 
        }
        catch(\PDOException $e)
        {
            $msg="Data Gagal dihapus. pastikan data child sudah hilang atau tidak berhubungan";
 
            return redirect()->route('status.index')->with('error',$msg);
        }
    }
}
