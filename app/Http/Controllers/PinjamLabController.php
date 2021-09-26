<?php

namespace App\Http\Controllers;

use App\Models\BarangDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lab;
use App\Models\Sesi;
use App\Models\Pinjam;
use App\Models\PinjamLab;
use App\Models\Block;
use App\Models\Rutin;
use Illuminate\Support\Facades\DB;
use App\Models\GambarBarang;

class PinjamLabController extends Controller
{
    /** ISI CLASS FOTO
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lab = Lab::all();
        $sesi = Sesi::select("*")->orderBy('mulai', 'ASC')->get();
        $fak = DB::select('SELECT DISTINCT fakultas FROM lab');
        return view('pinjamLab.index',compact('lab','fak','sesi'));
    }

    public static function cekSesi( $idlab, $date)
    {
        //0 tidak tersedia, 1 belum disetujui ,2 aman, 3 perbaikan
        $sesi = Sesi::select("*")->orderBy('mulai', 'ASC')->get();
        $hari = date("N", strtotime($date));
        $rutin = Rutin::where('idlab',$idlab)->where('hariint',$hari)->orderBy('jamMulai','ASC')->get();
        $lab = Lab::where('idlab',$idlab)->first();
        
        foreach ($sesi as $s)
        {
            $s->status = 2;
            $s->kuota = 0;

            if($lab->status != 0){$s->status = 0;}
            
            if($s->status == 2)
            {
                $pinjam = PinjamLab::where('idlab',$idlab)->where('tanggal',date("Y-m-d", strtotime($date)))->get();
                foreach ($pinjam as $p)
                {
                    if($s->mulai >= $p->mulai && $s->selesai <= $p->selesai) { 
                        if($p->statusDosen == "" || $p->statusKalab == "" ){ $s->status = 2; $s->kuota+=1; }
                        else {$s->status = 2; $s->kuota+=1; }
                    }
                }
            }

            if($s->status == 2)
            {
                $jumr = count($rutin);
                if($jumr > 0) 
                {
                    $pr = $rutin[0];
                }
                else{
                    $s->status = 0;
                }
                $countr = 1;
                foreach ($rutin as $r)
                {
                    if($countr == 1)
                    {
                        if($s->mulai < $r->jamMulai) { $s->status = 0; }
                        else if($s->selesai <= $r->jammulai) { $s->status = 0; }
                        else if($s->mulai >= $r->jamSelesai && $jumr == 1 ) { $s->status = 0; }
                    }   
                    else
                    {
                        if($s->mulai < $r->jamMulai && $s->mulai >= $pr->jamSelesai)  { $s->status = 0; }
                        else if($s->selesai <= $r->jammulai && $s->mulai >= $pr->jamSelesai) { $s->status = 0; }
                        else if($s->mulai >= $r->jamSelesai && $s->mulai >= $pr->jamSelesai && $jumr == $countr) { $s->status = 0; }
                    }
                    $countr+=1;
                    if($jumr>1) { $pr = $r;}
                }
            }
           
            if($s->status == 2)
            {
                $block = Block::where('idlab',$idlab)->where('tanggal',date("Y-m-d", strtotime($date)))->get();
                foreach ($block as $b)
                {
                    if($s->mulai >= $b->mulai && $s->selesai <= $b->selesai) { 
                        {$s->status = 0; }
                    }
                }
            }
            $s->kuota = $lab->kapasitas - $s->kuota;
            if($s->kuota <= 0)
            {
                $s->status = 0; 
            }
        }
        return $sesi;
    }

    public static function cekAda($idlab, $date, $mulai, $selesai)
    {
        $sesi = Sesi::select("*")->where('mulai','>=',$mulai)->where('selesai','<=',$selesai)->orderBy('mulai', 'ASC')->get();
        $jumlah = count($sesi);
        $pembanding = 0;
        $hari = date("N", strtotime($date));
        $rutin = Rutin::where('idlab',$idlab)->where('hariint',$hari)->orderBy('jamMulai','ASC')->get();
        $lab = Lab::where('idlab',$idlab)->first();
        foreach ($sesi as $s)
        {
            $s->status = 1;
            $s->kuota = 0;

            if($lab->status != 0){$s->status = 0;}
            
            if($s->status == 1)
            {
                $pinjam = PinjamLab::where('idlab',$idlab)->where('tanggal',date("Y-m-d", strtotime($date)))->get();
                foreach ($pinjam as $p)
                {
                    if($s->mulai >= $p->mulai && $s->selesai <= $p->selesai) { 
                        if($p->statusDosen == "" || $p->statusKalab == "" ){ $s->status = 1; $s->kuota+=1; }
                        else {$s->status = 1; $s->kuota+=1; }
                    }
                }
            }

            if($s->status == 1)
            {
                $jumr = count($rutin);
                if($jumr > 0) 
                {
                    $pr = $rutin[0];
                }
                else{
                    $s->status = 0;
                }
                $countr = 1;
                foreach ($rutin as $r)
                {
                    if($countr == 1)
                    {
                        if($s->mulai < $r->jamMulai) { $s->status = 0; }
                        else if($s->selesai <= $r->jammulai) { $s->status = 0; }
                        else if($s->mulai >= $r->jamSelesai && $jumr == 1 ) { $s->status = 0; }
                    }   
                    else
                    {
                        if($s->mulai < $r->jamMulai && $s->mulai >= $pr->jamSelesai)  { $s->status = 0; }
                        else if($s->selesai <= $r->jammulai && $s->mulai >= $pr->jamSelesai) { $s->status = 0; }
                        else if($s->mulai >= $r->jamSelesai && $s->mulai >= $pr->jamSelesai && $jumr == $countr) { $s->status = 0; }
                    }
                    $countr+=1;
                    if($jumr>1) { $pr = $r;}
                }
            }
           
            if($s->status == 1)
            {
                $block = Block::where('idlab',$idlab)->where('tanggal',date("Y-m-d", strtotime($date)))->get();
                foreach ($block as $b)
                {
                    if($s->mulai >= $b->mulai && $s->selesai <= $b->selesai) { 
                        {$s->status = 0; }
                    }
                }
            }

            if(($lab->kapasitas - $s->kuota)<=0){$s->status == 0; }
            $pembanding+=$s->status;
        }

        if($pembanding == $jumlah)
        {
            $cart=Session()->get('cart');
            if(isset($cart[$idlab]))
            {
                $help2 = 0;
                foreach ($cart[$idlab]['pinjam'] as $p)
                {
                    if($p['tgl']==$date)
                    {
                        $m1 = strtotime($p['mulai']);
                        $s1 = strtotime($p['selesai']);
                        $m2 = strtotime($mulai);
                        $s2 = strtotime($selesai);

                        if($m1 <= $m2 && $s1 >= $s2){$help2 = 1; }
                        elseif($m1 >= $m2 && $s1 <= $s2){$help2 = 1; }
                        else if($m1 >= $m2 && $s1 >= $s2 && $m1<=$s2){$help2 = 1; }
                        else if($m1 <= $m2 && $s1 <= $s2 && $m1>=$s2){$help2 = 1; }
                    }
                }
                if($help2 == 1){return 2;}
                else {return 0;}
            }
            else { return 0 ; }
            
        }
        else{
            return 1;
        }
        
        
    }

    public function detail($id)
    {
        $lab = Lab::where('idlab',$id)->first();
        $laboran = DB::select("select * from laboran l inner join users u on l.user = u.id where l.lab = '".$id."'");
        $bantuan = DB::select("select namafile from gambar where lab = '".$id."'");
        $rutin = Rutin::where('idlab',$id)->orderBy('hariint','ASC')->orderBy('jamMulai','ASC')->get();
        $sesi = $this->cekSesi($id, date("Y-m-d"));

        return view('pinjamLab.detail',compact('bantuan','lab','sesi','rutin','laboran'));
    }

    public function jadwal(Request $request)
    {
        $sesi = $this->cekSesi( $request->lab, $request->tgl);
       // dd($request);
        return view('pinjamLab.jadwal',compact('sesi'));
    }

    public function tgl(Request $request)
    {
        if(isset($request->mulai))
        {
            $sesi = $this->cekSesi( $request->lab, $request->tgl);
            $kirim = array();
            $help;
            foreach($sesi as $s)
            {
                if($s->mulai >= $request->mulai && $s->status != 2) { $help = $s; break; }
            }
            foreach($sesi as $s)
            {
                if($s->mulai >= $request->mulai && $s->mulai < $help->mulai) array_push($kirim,$s);
            }
            return $kirim;
        }
        else{
            return $sesi = $this->cekSesi( $request->lab, $request->tgl);
        }
    }

    public function tambah(Request $request)
    {
        $lab = Lab::where('idlab',$request->idlab)->first();
        $pinjam['tgl'] = $request->tgl;
        $pinjam['mulai'] = $request->wktmul;
        $pinjam['selesai'] = $request->wktsel;

        $cek = $this->cekAda($request->idlab,$request->tgl,$request->wktmul, $request->wktsel );
        //dd($cek);
        if($cek==0 )
        {
            $cart=Session()->get('cart');
            if(!isset($cart[$lab->idlab]))
            {
                $gambar = $this->gambar($lab->idlab);
                if($gambar==null) $gambar = "";
            
                $cart[$lab->idlab]=[
                    "id"=>$lab->idlab,
                    "nama"=> $lab->namaLab,
                    "lokasi"=> $lab->lokasi,
                    "gambar" => $gambar,
                    "pinjam" => array($pinjam),
                    "fakultas" =>$lab->fakultas,
                    "tipe" =>"lab"
                ];
            }
            else
            {
                array_push($cart[$lab->idlab]['pinjam'],$pinjam);
            }
            session()->put('cart',$cart);
            return redirect()->back()->with("status",3);
        }
        else if($cek == 1)
        {
            return redirect()->back()->with("status",1);
        }
        else if($cek == 2)
        {
            return redirect()->back()->with("status",2);
        }
        
        //return redirect('/peminjaman/detail2/'.$request->idbarang);
    }


    public static function gambar($id)
    {
        $bantuan = DB::select("select namafile from gambar where lab = '".$id."' limit 1");
        if(count($bantuan)>=1) { return $bantuan[0]->namafile; }
        else if(count($bantuan)==0) { return ""; }
    }

    public function filter(Request $request)
    {
        $query = 'select * from lab l ';
        $jumlah = 0;
        $filter = array();
        //dd($request);
        if($request->nama != "")
        {
            $query = $query . 'where namaLab like \'%' . $request->nama . '%\' ';
            $jumlah++;
            $filter['nama'] = $request->nama;
        }
        if($request->fakultas != "ALL")
        {
            if($jumlah == 0){ $query.= ' where '; }
            else if($jumlah == 1){ $query.= ' and '; }
            $query = $query . 'fakultas= \'' . $request->fakultas . '\' ';
            $jumlah++;
            $filter['fakultas'] = $request->fakultas;
        }
        if($request->tgl != "ALL")
        {
            if($jumlah == 0){ $query.= ' where '; }
            else if($jumlah == 1){ $query.= ' and '; }
            $query = $query . 'tgl= \'' . $request->fakultas . '\' ';
            $jumlah++;
            $filter['tgl'] = $request->fakultas;
        }
        if($request->jammul != "ALL")
        {
            if($jumlah == 0){ $query.= ' where '; }
            else if($jumlah == 1){ $query.= ' and '; }
            $query = $query . 'jm= \'' . $request->fakultas . '\' ';
            $jumlah++;
            $filter['jamul'] = $request->jamul;
        }
        if($request->jamsel != "ALL")
        {
            if($jumlah == 0){ $query.= ' where '; }
            else if($jumlah == 1){ $query.= ' and '; }
            $query = $query . 'js= \'' . $request->fakultas . '\' ';
            $jumlah++;
            $filter['jasel'] = $request->jasel;
        }
       // dd($request);
        $lab = DB::select($query);
        $sesi = Sesi::all();
        $fak = DB::select('SELECT DISTINCT fakultas FROM lab');
        return view('pinjamlab.index',compact('lab','fak','sesi','filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //
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
        //
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
