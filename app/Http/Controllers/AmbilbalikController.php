<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Pinjam;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\PinjamLab;
use App\Models\Order;
use App\Models\History;
use App\Models\Email;
use App\Models\Ambilbalik;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\PinjamLabController;
use Illuminate\Support\Facades\DB;
use App\Mail\emailOrder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AmbilbalikController extends Controller
{
    public function index()
    {
        
    }
    public function ambildetail($id)
    {

    }

    public function ambil($id)
    {
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');
        $order = Order::where('idorder',$id)->get();
        if(KeranjangController::laborannya($id,auth()->user()->nrpnpk) == 0)
        {
            return redirect(url('/home'))->with("status",4);
        }
        else if (KeranjangController::laborannya($id,auth()->user()->nrpnpk) > 0 || auth()->user()->jabatan == 9){

            if(auth()->user()->jabatan == 9){
                $lab = DB::select("select DISTINCT la.idlab, la.namaLab, la.fakultas from lab la left join (select DISTINCT bd.lab as lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.idlab = lb.lab left join laboran lc on lb.lab = lc.lab");
            }
            else{
                $lab = DB::select("select DISTINCT la.idlab, la.namaLab, la.fakultas from lab la left join (select DISTINCT bd.lab as lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.idlab = lb.lab left join laboran lc on lb.lab = lc.lab where user = '".auth()->user()->nrpnpk."'");
            }
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp,p.checkout1,p.checkin1, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai ,  p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' and l.idlab = '".$lab[0]->idlab."' order by b.nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai ,p.checkout1,p.checkin1, p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' and l.idlab = '".$lab[0]->idlab."' order by l.namaLab");
            $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
            $keranjang = array();
            $penampung = "";
            foreach($pesanankubarang as $pb)
            {
                    $cek = DB::select('select count(idp) as jumlah from pinjam where barang = "'.$pb->idbarangdetail.'"and checkin != "" and checkout1 = ""');
                    $pinjam['okay'] = $cek[0]->jumlah;
                    $pinjam['tgl'] = $pb->tanggal;
                    $pinjam['mulai'] = $pb->mulai;
                    $pinjam['selesai'] = $pb->selesai;
                    $pinjam['checkin'] = $pb->checkin;
                    $pinjam['checkout'] = $pb->checkout;
                    $pinjam['idp'] = $pb->idp;
                    $pinjam['statusDosen'] = $pb->statusDosen;
                    $pinjam['masalah'] = $pb->masalah;
                    $pinjam['statusKalab'] = $pb->statusKalab;
                    $pinjam['keterangan'] = $pb->keterangan;
                    $pinjam['status'] = $pb->status;
                    $pinjam['sdosen'] = $pb->sdosen;
                    $pinjam['skalab'] = $pb->skalab;
                    $pinjam['checkin1'] = $pb->checkin1;
                    $pinjam['checkout1'] = $pb->checkout1;
                    
                if(!isset($keranjang[$pb->idbarangdetail]))
                {
                    $help['id'] = $pb->idbarangdetail;
                    $help['nama'] = $pb->nama;
                    $help['merk'] = $pb->merk;
                    $help['barang'] = $pb->namaBarang;
                    $help['kat'] = $pb->kategori;
                    $help['gambar'] = PinjamController::gambardt($pb->idbarangdetail);
                    $help['pinjam'] = array($pinjam);
                    $help['lab'] = $pb->namaLab;
                    $help['lokasi'] = $pb->lokasi;
                    $help['fakultas'] = $pb->fakultas;
                    $help['tipe'] = "barang";
                    foreach($laboran as $la)
                    {
                        if($pb->idlab == $la->lab)
                        $keranjang[$pb->idbarangdetail] = $help;
                    }
                }
                else
                {
                    foreach($laboran as $la)
                    {
                        if($pb->idlab == $la->lab)
                        { array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam); }
                    }
                }
            }
            foreach($pesanankulab as $pb)
            {
                    $pinjam['tgl'] = $pb->tanggal;
                    $pinjam['mulai'] = $pb->mulai;
                    $pinjam['selesai'] = $pb->selesai;
                    $pinjam['checkin'] = $pb->checkin;
                    $pinjam['checkout'] = $pb->checkout;
                    $pinjam['idpl'] = $pb->idpl;
                    $pinjam['statusDosen'] = $pb->statusDosen;
                    $pinjam['masalah'] = $pb->masalah;
                    $pinjam['statusKalab'] = $pb->statusKalab;
                    $pinjam['keterangan'] = $pb->keterangan;
                    $pinjam['status'] = $pb->status;
                    $pinjam['sdosen'] = $pb->sdosen;
                    $pinjam['skalab'] = $pb->skalab;
                    $pinjam['checkin1'] = $pb->checkin1;
                    $pinjam['checkout1'] = $pb->checkout1;
                if(!isset($keranjang[$pb->idlab]))
                {
                    $help['id'] = $pb->idlab;
                    $help['nama'] = $pb->namaLab;
                    $help['lokasi'] = $pb->lokasi;
                    $help['gambar'] = PinjamLabController::gambar($pb->idlab);
                    $help['pinjam'] = array($pinjam);
                    $help['fakultas'] = $pb->fakultas;
                    $help['tipe'] = "lab";
                    //dd($laboran);

                    foreach($laboran as $la)
                    {
                        if($pb->idlab == $la->lab)
                        { $keranjang[$pb->idlab] = $help; }
                    }
                }
                else
                {   
                    foreach($laboran as $la)
                    {
                        if($pb->idlab == $la->lab)
                        { array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); } 
                    }
                }
            }
            $labdpl = $lab[0]->idlab;
           // dd($keranjang);
            return view('ambilbalik.ambil',compact('pemesan','dosenpj','lab','orderku','keranjang','labdpl'));
        }
    }

    public function ambillab(Request $request)
    {
        //dd($request->lab);
        $id = $request->orderid;
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');
        $order = Order::where('idorder',$id)->get();
        if(KeranjangController::laborannya($id,auth()->user()->nrpnpk) == 0)
        {
            return redirect(url('/home'))->with("status",4);
        }
        else if (KeranjangController::laborannya($id,auth()->user()->nrpnpk) > 0 || auth()->user()->jabatan == 9){
            $lab = DB::select("select DISTINCT la.idlab, la.namaLab, la.fakultas from lab la left join (select DISTINCT bd.lab as lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.idlab = lb.lab left join laboran lc on lb.lab = lc.lab where user = '".auth()->user()->nrpnpk."'");
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp,p.checkout1,p.checkin1, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai ,  p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' and l.idlab = '".$request->lab."' order by b.nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai ,p.checkout1,p.checkin1, p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' and l.idlab = '".$request->lab."' order by l.namaLab");
            $keranjang = array();
            $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
            $penampung = "";
            foreach($pesanankubarang as $pb)
            {
                    $pinjam['tgl'] = $pb->tanggal;
                    $pinjam['mulai'] = $pb->mulai;
                    $pinjam['selesai'] = $pb->selesai;
                    $pinjam['checkin'] = $pb->checkin;
                    $pinjam['checkout'] = $pb->checkout;
                    $pinjam['idp'] = $pb->idp;
                    $pinjam['statusDosen'] = $pb->statusDosen;
                    $pinjam['masalah'] = $pb->masalah;
                    $pinjam['statusKalab'] = $pb->statusKalab;
                    $pinjam['keterangan'] = $pb->keterangan;
                    $pinjam['status'] = $pb->status;
                    $pinjam['sdosen'] = $pb->sdosen;
                    $pinjam['skalab'] = $pb->skalab;
                    $pinjam['checkin1'] = $pb->checkin1;
                    $pinjam['checkout1'] = $pb->checkout1;
                    
                if(!isset($keranjang[$pb->idbarangdetail]))
                {
                    $help['id'] = $pb->idbarangdetail;
                    $help['nama'] = $pb->nama;
                    $help['merk'] = $pb->merk;
                    $help['barang'] = $pb->namaBarang;
                    $help['kat'] = $pb->kategori;
                    $help['gambar'] = PinjamController::gambardt($pb->idbarangdetail);
                    $help['pinjam'] = array($pinjam);
                    $help['lab'] = $pb->namaLab;
                    $help['lokasi'] = $pb->lokasi;
                    $help['fakultas'] = $pb->fakultas;
                    $help['tipe'] = "barang";
                    foreach($laboran as $la)
                    {
                        if($pb->idlab == $la->lab)
                        $keranjang[$pb->idbarangdetail] = $help;
                    }
                }
                else
                {
                    foreach($laboran as $la)
                    {
                        if($pb->idlab == $la->lab)
                        { array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam); }
                    }
                }
            }
            foreach($pesanankulab as $pb)
            {
                    $pinjam['tgl'] = $pb->tanggal;
                    $pinjam['mulai'] = $pb->mulai;
                    $pinjam['selesai'] = $pb->selesai;
                    $pinjam['checkin'] = $pb->checkin;
                    $pinjam['checkout'] = $pb->checkout;
                    $pinjam['idpl'] = $pb->idpl;
                    $pinjam['statusDosen'] = $pb->statusDosen;
                    $pinjam['masalah'] = $pb->masalah;
                    $pinjam['statusKalab'] = $pb->statusKalab;
                    $pinjam['keterangan'] = $pb->keterangan;
                    $pinjam['status'] = $pb->status;
                    $pinjam['sdosen'] = $pb->sdosen;
                    $pinjam['skalab'] = $pb->skalab;
                    $pinjam['checkin1'] = $pb->checkin1;
                    $pinjam['checkout1'] = $pb->checkout1;

                if(!isset($keranjang[$pb->idlab]))
                {
                    $help['id'] = $pb->idlab;
                    $help['nama'] = $pb->namaLab;
                    $help['lokasi'] = $pb->lokasi;
                    $help['gambar'] = PinjamLabController::gambar($pb->idlab);
                    $help['pinjam'] = array($pinjam);
                    $help['fakultas'] = $pb->fakultas;
                    $help['tipe'] = "lab";
                    //dd($laboran);

                    foreach($laboran as $la)
                    {
                        if($pb->idlab == $la->lab)
                        { $keranjang[$pb->idlab] = $help; }
                    }
                }
                else
                {   
                    foreach($laboran as $la)
                    {
                        if($pb->idlab == $la->lab)
                        { array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); } 
                    }
                }
            }
            $labdpl = $request->lab;
            return view('ambilbalik.ambil',compact('pemesan','dosenpj','lab','orderku','keranjang','labdpl'));
        }
    }

    public function prosesambil(Request $request)
    {
        $id = $request->orderid;
        $mylab = $request->labdpl;
        $keranjang = array();
        $pesan = $request->pesan;
        $kodep = $request->kodep;

        $kodepa = Ambilbalik::where('abcode',$kodep)->where('order',$id)->get();
        if(count($kodepa) > 0 || $kodep == "" || strlen($kodep) != 6)
        {
            return redirect('/ambil/all/'.$id)->with('status', '3');
        }
      
        if(isset($request->ambilall))
        {   
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' and l.idlab = '".$mylab."' order by b.nama");
            $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab,l.kapasitas, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' and p.idlab = '".$mylab."' order by l.namaLab");
            $penampung = "";
            foreach($pesanankubarang as $pb)
            {
                    $cek = DB::select('select count(idp) as jumlah from pinjam where barang = "'.$pb->idbarangdetail.'"and checkin != "" and checkout1 = ""');
                    $pinjam['okay'] = $cek[0]->jumlah;
                    $pinjam['tgl'] = $pb->tanggal;
                    $pinjam['mulai'] = $pb->mulai;
                    $pinjam['selesai'] = $pb->selesai;
                    $pinjam['checkin'] = $pb->checkin;
                    $pinjam['checkout'] = $pb->checkout;
                    $pinjam['idp'] = $pb->idp;
                    $pinjam['statusDosen'] = $pb->statusDosen;
                    $pinjam['masalah'] = $pb->masalah;
                    $pinjam['statusKalab'] = $pb->statusKalab;
                    $pinjam['keterangan'] = $pb->keterangan;
                    $pinjam['status'] = $pb->status;
                    $pinjam['sdosen'] = $pb->sdosen;
                    $pinjam['skalab'] = $pb->skalab;
                    
                if(!isset($keranjang[$pb->idbarangdetail]))
                {
                    $help['id'] = $pb->idbarangdetail;
                    $help['nama'] = $pb->nama;
                    $help['merk'] = $pb->merk;
                    $help['barang'] = $pb->namaBarang;
                    $help['kat'] = $pb->kategori;
                    $help['gambar'] = PinjamController::gambardt($pb->idbarangdetail);
                    $help['pinjam'] = array($pinjam);
                    $help['lab'] = $pb->namaLab;
                    $help['lokasi'] = $pb->lokasi;
                    $help['fakultas'] = $pb->fakultas;
                    $help['tipe'] = "barang";

                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 )
                    {}
                    else
                    { $keranjang[$pb->idbarangdetail] = $help; }
                    
                }
                else
                {
                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 )
                    {}
                    else
                    { array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam); }
                }
            }
            foreach($pesanankulab as $pb)
            {
                    //$cek = DB::select('select count(idp) as jumlah from pinjamLab where idlab = "'.$pb->idlab.'"and checkin != "" and checkout1 = ""');
                    //$pinjam['okay'] = $cek[0]->jumlah;
                    //$pinjam['kapasitas'] = $cek[0]->kapasitas;
                    $pinjam['tgl'] = $pb->tanggal;
                    $pinjam['mulai'] = $pb->mulai;
                    $pinjam['selesai'] = $pb->selesai;
                    $pinjam['checkin'] = $pb->checkin;
                    $pinjam['checkout'] = $pb->checkout;
                    $pinjam['idpl'] = $pb->idpl;
                    $pinjam['statusDosen'] = $pb->statusDosen;
                    $pinjam['masalah'] = $pb->masalah;
                    $pinjam['statusKalab'] = $pb->statusKalab;
                    $pinjam['keterangan'] = $pb->keterangan;
                    $pinjam['status'] = $pb->status;
                    $pinjam['sdosen'] = $pb->sdosen;
                    $pinjam['skalab'] = $pb->skalab;
                if(!isset($keranjang[$pb->idlab]))
                {
                    $help1['id'] = $pb->idlab;
                    $help1['nama'] = $pb->namaLab;
                    $help1['lokasi'] = $pb->lokasi;
                    $help1['gambar'] = PinjamLabController::gambar($pb->idlab);
                    $help1['pinjam'] = array($pinjam);
                    $help1['fakultas'] = $pb->fakultas;
                    $help1['tipe'] = "lab";

                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 )
                    {}
                    else
                    { $keranjang[$pb->idlab] = $help1; }
                }
                else
                {
                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 )
                    {}
                    else
                    { array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); }
                }
            }
        }
        else{
            $orderku = Order::where('idorder',$id)->get();
            if($request->diambilb != null){
                foreach($request->diambilb as $cb)
                {
                    $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$cb."'");
                    foreach($pesanankubarang as $pb)
                    {
                        $cek = DB::select('select count(idp) as jumlah from pinjam where barang = "'.$pb->idbarangdetail.'"and checkin != "" and checkout1 = ""');
                        $pinjam['okay'] = $cek[0]->jumlah;
                        $pinjam['tgl'] = $pb->tanggal;
                        $pinjam['mulai'] = $pb->mulai;
                        $pinjam['selesai'] = $pb->selesai;
                        $pinjam['checkin'] = $pb->checkin;
                        $pinjam['checkout'] = $pb->checkout;
                        $pinjam['idp'] = $pb->idp;
                        $pinjam['statusDosen'] = $pb->statusDosen;
                        $pinjam['masalah'] = $pb->masalah;
                        $pinjam['statusKalab'] = $pb->statusKalab;
                        $pinjam['keterangan'] = $pb->keterangan;
                        $pinjam['status'] = $pb->status;
                        $pinjam['sdosen'] = $pb->sdosen;
                        $pinjam['skalab'] = $pb->skalab;
                        
                        if(!isset($keranjang[$pb->idbarangdetail]))
                        {
                            $help['id'] = $pb->idbarangdetail;
                            $help['nama'] = $pb->nama;
                            $help['merk'] = $pb->merk;
                            $help['barang'] = $pb->namaBarang;
                            $help['kat'] = $pb->kategori;
                            $help['gambar'] = PinjamController::gambardt($pb->idbarangdetail);
                            $help['pinjam'] = array($pinjam);
                            $help['lab'] = $pb->namaLab;
                            $help['lokasi'] = $pb->lokasi;
                            $help['fakultas'] = $pb->fakultas;
                            $help['tipe'] = "barang";

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 )
                            {}
                            else
                            { $keranjang[$pb->idbarangdetail] = $help; }
                            
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 )
                            {}
                            else
                            { array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam); }
                        }
                    }
                }
            }
            if($request->diambill != null) {
                foreach($request->diambill as $cl)
                {
                    $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$cl."'");
                    foreach($pesanankulab as $pb)
                    {
                        //$cek = DB::select('select count(idp) as jumlah from pinjamLab where idlab = "'.$pb->idlab.'"and checkin != "" and checkout1 = ""');
                        //$pinjam['okay'] = $cek[0]->jumlah;
                        //$pinjam['kapasitas'] = $cek[0]->kapasitas;
                        $pinjam['tgl'] = $pb->tanggal;
                        $pinjam['mulai'] = $pb->mulai;
                        $pinjam['selesai'] = $pb->selesai;
                        $pinjam['checkin'] = $pb->checkin;
                        $pinjam['checkout'] = $pb->checkout;
                        $pinjam['idpl'] = $pb->idpl;
                        $pinjam['statusDosen'] = $pb->statusDosen;
                        $pinjam['masalah'] = $pb->masalah;
                        $pinjam['statusKalab'] = $pb->statusKalab;
                        $pinjam['keterangan'] = $pb->keterangan;
                        $pinjam['status'] = $pb->status;
                        $pinjam['sdosen'] = $pb->sdosen;
                        $pinjam['skalab'] = $pb->skalab;
                        if(!isset($keranjang[$pb->idlab]))
                        {
                            $help['id'] = $pb->idlab;
                            $help['nama'] = $pb->namaLab;
                            $help['lokasi'] = $pb->lokasi;
                            $help['gambar'] = PinjamLabController::gambar($pb->idlab);
                            $help['pinjam'] = array($pinjam);
                            $help['fakultas'] = $pb->fakultas;
                            $help['tipe'] = "lab";

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 )
                            {}
                            else
                            { $keranjang[$pb->idlab] = $help; }
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 )
                            {}
                            else
                            { array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); }
                        }
                    }
                }
            }
        }
        if(count($keranjang) == 0)
        {
            return redirect('/ambil/all/'.$id)->with('status', '2');
        }
        else{
            return view("ambilbalik.konfirmasiambil",compact('orderku','keranjang','pesan','kodep'));
        }
    }

    public function finalambil(Request $request)
    {
        $id = $request->orderid;
        $helper = 0;
        $orderku = Order::where('idorder',$id)->get();
        if($request->ambilb != null){
            foreach($request->ambilb as $cb)
            {
                $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$cb."'");
                foreach($pesanankubarang as $pb)
                {
                    $cek = DB::select('select count(idp) as jumlah from pinjam where barang = "'.$pb->idbarangdetail.'"and checkin != "" and checkout1 = ""');
                    if($pb->sdosen != 1 || $pb->status != 1 || $pb->checkout == "" || $pb->checkin == "" || $pb->skalab != 1 || $cek[0]->jumlah > 0 )
                    { $helper++; }
                }
            }
        }
        if($request->ambill != null) {
            foreach($request->ambill as $cl)
            {
                $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$cl."'");
                foreach($pesanankulab as $pb)
                {
                    if($pb->sdosen != 1 || $pb->status != 1 || $pb->checkout == "" || $pb->checkin == "" || $pb->skalab != 1 )
                    { $helper++; }
                }
            }
        }
        if($helper >= 1)
        {
            return redirect('/ambil/all/'.$id)->with('status', '1');
        }
        else{
            
            $jumlah = DB::select("select count(a.idambilbalik) as jumlah from ambilbalik a where a.order = '".$id."'");
            $idab = $id.str_pad($jumlah[0]->jumlah ,3,"0",STR_PAD_LEFT);
            $ambilin = new Ambilbalik;
            $ambilin->idambilbalik = $idab;
            $ambilin->order = $id;
            $ambilin->note = $request->pesan;
            $ambilin->abcode = $request->kodep;
            $ambilin->tipe = "AMBIL";
            $ambilin->time = date("Y-m-d H:i:s");
            $ambilin->pic = auth()->user()->nrpnpk;
            //$ambilin->save();

            if($request->ambilb != null){
                foreach($request->ambilb as $cb)
                {
                    //dd("update pinjam set checkin = now(), ambil = '".$idab."' where idp = '".$cb."'");
                    DB::statement("update pinjam set checkin = now(), ambil = '".$idab."' where idp = '".$cb."'");
                }
            }
            if($request->ambill != null) {
                foreach($request->ambill as $cl)
                {
                   DB::statement("update pinjamlab set chechin = now() , ambil = '".$idab."' where idpl = '".$cl."'");
                }
            }

            $riwayat = new History;
            $riwayat->status = 7;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->pic =auth()->user()->nrpnpk;
            $riwayat->order = $id;
           //$riwayat->save();
            //KeranjangController::kirimemail($id,'Item Pada Pesanan Anda Berhasil Dibatalkan','Item Pada Pesanan Anda Berhasil Dibatalkan','Pesanan Yang Berkaitan Dengan Anda Berhasil Dibatalkan','Pesanan Yang Berkaitan Dengan Anda Berhasil Dibatalkan','batal');
          //  return redirect('/order/detail/'.$id)->with('status', '1');
        }
        
    }
}
