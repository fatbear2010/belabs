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
use App\Models\Block;
use App\Models\Rutin;
use App\Models\User;
use App\Models\Fakultas;
use Illuminate\Support\Facades\DB;
use App\Models\GambarBarang;

class PinjamController extends Controller
{
    /** ISI CLASS FOTO
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        $lab = Lab::all();
        $cat = Kategori::all();
        $sesi = Sesi::select("*")->orderBy('mulai', 'ASC')->get();
        $fak = Fakultas::all();
        return view('pinjam.index',compact('barang','lab', 'fak','cat','sesi'));
    }
    public static function fakultas1($id)
    {
        $fak = Fakultas::where('idfakultas',$id)->first();
        return $fak;
    }
    public static function dosen1($id)
    {
        $dos = User::where('nrpnpk',$id)->first();
        return $dos;
    }
    public function detail($id)
    {
        $barang = Barang::where('idbarang',$id)->first();
        $kategori = DB::select("select * from kategori where idkategori = '".$barang->kategori."'");
        $barangdt = BarangDetail::where('idbarang',$id)->get();
        $bantuan = DB::select('SELECT * FROM gambar g inner join barangdetail b on g.barang = b.idbarangDetail where b.idbarang = \''.$id.'\'');
        //if(!isset($bantuan->namafile))$bantuan = array(array("namafile"=>""),array("namafile"=>""),array("namafile"=>""));
        //dd($bantuan);
        return view('pinjam.detail',compact('barangdt','bantuan','barang','kategori'));
    }

    public static function cekSesi(  $idbarang, $date)
    {
         //0 tidak tersedia, 1 belum disetujui ,2 aman, 3 perbaikan
        $sesi = Sesi::select("*")->orderBy('mulai', 'ASC')->get();
        $hari = date("N", strtotime($date));
        $rutin = Rutin::where('idbarangDetail',$idbarang)->where('hariint',$hari)->orderBy('jamMulai','ASC')->get();
        $barangdt = BarangDetail::where('idbarangDetail',$idbarang)->first();
        foreach ($sesi as $s)
        {
            $s->status = 2;

            if($barangdt->status != 0){$s->status = 0;}
            else if($barangdt->kondisi == 1){$s->status = 0;}
            else if($barangdt->perbaikan == 1){$s->status = 3;}
            
            if($s->status == 2)
            {
                $pinjam = Pinjam::where('barang',$idbarang)->where('status','1')->where('tanggal',date("Y-m-d", strtotime($date)))->get();
                foreach ($pinjam as $p)
                {
                    if($s->mulai >= $p->mulai && $s->selesai <= $p->selesai) { 
                        if($p->statusDosen == "" || $p->statusKalab == "" ){ $s->status = 1; }
                        else {$s->status = 0; }
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
                $block = Block::where('idbarangDetail',$idbarang)->where('tanggal',date("Y-m-d", strtotime($date)))->get();
                foreach ($block as $b)
                {
                    if($s->mulai >= $b->mulai && $s->selesai <= $b->selesai) { 
                        {$s->status = 0; }
                    }
                }
            }

            if($s->status == 2 && (strtotime(date("Y-m-d"))>= strtotime($date) ))
            {
                if(strtotime($s->mulai)-1800 <= time() ) {
                    $s->status = 0;
                }
            }

            if($s->status == 2)
            {
                $cart=Session()->get('cart');
                if(isset($cart[$idbarang]))
                {
                    $help2 = 0;
                    foreach ($cart[$idbarang]['pinjam'] as $p)
                    {
                        if($p['tgl']==$date)
                        {
                            $m1 = strtotime($p['mulai']);
                            $s1 = strtotime($p['selesai']);
                            $m2 = strtotime($s->mulai);
                            $s2 = strtotime($s->selesai);

                            if($m1 <= $m2 && $s1 >= $s2){$help2 = 1; }
                            elseif($m1 >= $m2 && $s1 <= $s2){$help2 = 1; }
                            else if($m1 >= $m2 && $s1 >= $s2 && $m1<=$s2){$help2 = 1; }
                            else if($m1 <= $m2 && $s1 <= $s2 && $m1>=$s2){$help2 = 1; }
                        }
                    }
                    if($help2 == 1){ $s->status = 4; }
                }
            }
        }
        return $sesi;
    }

    public static function cekAda(  $idbarang, $date, $mulai, $selesai)
    {
        $sesi = Sesi::select("*")->where('mulai','>=',$mulai)->where('selesai','<=',$selesai)->orderBy('mulai', 'ASC')->get();
        $jumlah = count($sesi);
        $pembanding = 0;
        $hari = date("N", strtotime($date));
        $rutin = Rutin::where('idbarangDetail',$idbarang)->where('hariint',$hari)->orderBy('jamMulai','ASC')->get();
        $barangdt = BarangDetail::where('idbarangDetail',$idbarang)->first();
        foreach ($sesi as $s)
        {
            $s->status = 1;

            if($barangdt->status != 0){$s->status = 0;}
            else if($barangdt->kondisi == 1){$s->status = 0;}
            else if($barangdt->perbaikan == 1){$s->status = 0;}
            
            if($s->status == 1)
            {
                $pinjam = Pinjam::where('barang',$idbarang)->where('status','1')->where('tanggal',date("Y-m-d", strtotime($date)))->get();
                foreach ($pinjam as $p)
                {
                    if($s->mulai >= $p->mulai && $s->selesai <= $p->selesai) { 
                        if($p->statusDosen == "" || $p->statusKalab == "" ){ $s->status = 0; }
                        else {$s->status = 0; }
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
                $block = Block::where('idbarangDetail',$idbarang)->where('tanggal',date("Y-m-d", strtotime($date)))->get();
                foreach ($block as $b)
                {
                    if($s->mulai >= $b->mulai && $s->selesai <= $b->selesai) { 
                        {$s->status = 0; }
                    }
                }
            }

            if($s->status == 1 && (strtotime(date("Y-m-d"))>= strtotime($date) ))
            {
                if(strtotime($s->mulai)-1800 <= time() ) {
                    $s->status = 0;
                }
            }

            $pembanding+=$s->status;
        }

        if($pembanding == $jumlah)
        {
            $cart=Session()->get('cart');
            if(isset($cart[$idbarang]))
            {
                $help2 = 0;
                foreach ($cart[$idbarang]['pinjam'] as $p)
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

    public function detail2($id)
    {
        $barang = DB::select('select b.nama , b.kategori, b.idbarang from barang b inner join barangdetail d on b.idbarang = d.idbarang where d.idbarangDetail = \''.$id.'\'');
        $barangdt = BarangDetail::where('idbarang',$barang[0]->idbarang)->get();
        $kategori = DB::select("select * from kategori where idkategori = '".$barang[0]->kategori."'");
        $barangdpl = BarangDetail::where('idbarangDetail',$id)->first();
        $bantuan = DB::select("select namafile from gambar where barang = '".$id."'");
        $rutin = Rutin::where('idbarangDetail',$barangdpl->idbarangDetail)->orderBy('hariint','ASC')->orderBy('jamMulai','ASC')->get();
        $sesi = $this->cekSesi($barangdpl->idbarangDetail, date("Y-m-d"));

        return view('pinjam.detail2',compact('barangdt','bantuan','barang','barangdpl','kategori','sesi','rutin',));
    }

    public function jadwal(Request $request)
    {
        $sesi = $this->cekSesi( $request->barang, $request->tgl);
       // dd($request);
        return view('pinjam.jadwal',compact('sesi'));
    }

    public function tgl(Request $request)
    {
        if(isset($request->mulai))
        {
            $sesi = $this->cekSesi( $request->barang, $request->tgl);
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
            return $sesi = $this->cekSesi( $request->barang, $request->tgl);
        }
    }

    public function tambah(Request $request)
    {
        $barangdpl = BarangDetail::where('idbarangDetail',$request->idbarang)->first();
        $pinjam['tgl'] = $request->tgl;
        $pinjam['mulai'] = $request->wktmul;
        $pinjam['selesai'] = $request->wktsel;

        $cek = $this->cekAda($request->idbarang,$request->tgl,$request->wktmul, $request->wktsel );
        //dd($cek);
        if($cek==0 )
        {
            $cart=Session()->get('cart');
            if(!isset($cart[$barangdpl->idbarangDetail]))
            {
                $barang = Barang::where('idbarang',$barangdpl->idbarang)->first();
                $kategori = DB::select("select * from kategori where idkategori = '".$barang->kategori."'");
                $gambar = $this->gambardt($barangdpl->idbarangDetail);
                if($gambar==null) $gambar = "";
                $lab = $this->lab($barangdpl->lab);
            
                $cart[$barangdpl->idbarangDetail]=[
                    "id"=>$barangdpl->idbarangDetail,
                    "idbrg"=>$barang->idbarang,
                    "merk"=> $barangdpl->merk,
                    "nama"=> $barangdpl->nama,
                    "barang" =>$barang->nama,
                    "kat"=> $kategori[0]->nama,
                    "gambar" => $gambar,
                    "pinjam" => array($pinjam),
                    "lab" => $lab->namaLab,
                    "fakultas" =>$lab->fakultas,
                    "tipe" =>"barang"
                ];
            }
            else
            {
                array_push($cart[$barangdpl->idbarangDetail]['pinjam'],$pinjam);
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

    public static function lab($id)
    {
        $bantuan = lab::where('idlab',$id)->first();
        if(isset($bantuan->idlab)) return $bantuan;
        else return "";
    }

    public static function gambar($id)
    {
        $bantuan = DB::select("select namafile from gambar g inner join barangdetail b on g.barang = b.idbarangdetail where idbarang = '".$id."' limit 1");
        if(count($bantuan)>=1) { return $bantuan[0]->namafile; }
        else if(count($bantuan)==0) { return ""; }
    }
    public static function gambardt($id)
    {
        $bantuan = DB::select("select namafile from gambar where barang = '".$id."' limit 1");
        //dd($id);
        if(count($bantuan)>=1) { return $bantuan[0]->namafile; }
        else if(count($bantuan)==0) { return ""; }
    }

    public function filter(Request $request)
    {
        $query = 'select b.nama as nama, b.idbarang as idbarang from barang b left join barangdetail d on b.idbarang = d.idbarang left join lab l on l.idlab = d.lab ';
        $jumlah = 0;
        $filter = array();
        if($request->nama != "")
        {
            $query = $query . 'where b.nama like \'%' . $request->nama . '%\' ';
            $jumlah++;
            $filter['nama'] = $request->nama;
        }
        if($request->fakultas != "ALL")
        {
            if($jumlah == 0){ $query.= ' where '; }
            else if($jumlah == 1){ $query.= ' and '; }
            $query = $query . 'l.fakultas= \'' . $request->fakultas . '\' ';
            $jumlah++;
            $filter['fakultas'] = $request->fakultas;
            $filter['namafakultas'] = $this->fakultas1($request->fakultas)->namafakultas;
        }
        if($request->lab != "ALL")
        {
            if($jumlah == 0){ $query.= ' where '; }
            else if($jumlah >= 1){ $query.= ' and '; }
            $query = $query . 'l.namaLab= \'' . $request->lab . '\' ';
            $jumlah++;
            $filter['laboratorium'] = $request->lab;
        }
        if($request->cat != "ALL")
        {
            if($jumlah == 0){ $query.= ' where '; }
            else if($jumlah >= 1){ $query.= ' and '; }
            $query = $query . 'b.kategori= \'' . $request->cat . '\' ';
            $jumlah++;
            $filter['kategori'] = $request->cat;
        }
        $barang = DB::select($query);
       
        $lab = Lab::all();
        $cat = Kategori::all();
        $sesi = Sesi::all();
        $fak = Fakultas::all();
        
        //dd($barang);
        if($request->cat == "ALL" &&$request->lab == "ALL"&&$request->fakultas == "ALL" && $request->nama == "")
        {
            return view('pinjam.index',compact('barang','lab','fak','cat','sesi'));
        }
        else{
            return view('pinjam.index',compact('barang','lab','fak','cat','sesi','filter'));
        }
       // dd($request);
        
    }
    
    public static function cekAda1($date, $mulai, $selesai)
    {
        //selesai gaada dianggap sesi terakhir, mulai gaada diambil jam terawal, date gaada maka di for setiap hari 
        $sesi = Sesi::select("*")->where('mulai','>=',$mulai)->where('selesai','<=',$selesai)->orderBy('mulai', 'ASC')->get();
        $jumlah = count($sesi);
        $pembanding = 0;
        $hari = date("N", strtotime($date));
        $barang = BarangDetail::all();
        foreach($barang as $barangdt)
        {
            $rutin = Rutin::where('idbarangDetail',$barangdt->idbarangdetail)->where('hariint',$hari)->orderBy('jamMulai','ASC')->get();
            foreach ($sesi as $s)
            {
                $s->status = 1;

                if($barangdt->status != 0){$s->status = 0;}
                else if($barangdt->kondisi == 1){$s->status = 0;}
                else if($barangdt->perbaikan == 1){$s->status = 0;}
                
                if($s->status == 1)
                {
                    $pinjam = Pinjam::where('barang',$idbarang)->where('tanggal',date("Y-m-d", strtotime($date)))->get();
                    foreach ($pinjam as $p)
                    {
                        if($s->mulai >= $p->mulai && $s->selesai <= $p->selesai) { 
                            if($p->statusDosen == "" || $p->statusKalab == "" ){ $s->status = 0; }
                            else {$s->status = 0; }
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
                    $block = Block::where('idbarangDetail',$idbarang)->where('tanggal',date("Y-m-d", strtotime($date)))->get();
                    foreach ($block as $b)
                    {
                        if($s->mulai >= $b->mulai && $s->selesai <= $b->selesai) { 
                            {$s->status = 0; }
                        }
                    }
                }

                if($s->status == 1 && (strtotime(date("Y-m-d"))>= strtotime($date) ))
                {
                    if(strtotime($s->mulai)-1800 <= time() ) {
                        $s->status = 0;
                    }
                }
                $pembanding+=$s->status;
            }

        }    
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
