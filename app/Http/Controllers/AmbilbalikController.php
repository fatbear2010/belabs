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
                $lab = DB::select("select DISTINCT la.idlab, la.namaLab, la.fakultas from lab la left join (select DISTINCT bd.lab as lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamlab  where idorder = '".$id."') lb on la.idlab = lb.lab left join laboran lc on lb.lab = lc.lab");
            }
            else{
                $lab = DB::select("select DISTINCT la.idlab, la.namaLab, la.fakultas from lab la left join (select DISTINCT bd.lab as lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamlab  where idorder = '".$id."') lb on la.idlab = lb.lab left join laboran lc on lb.lab = lc.lab where user = '".auth()->user()->nrpnpk."'");
            }
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp,p.checkout1,p.checkin1, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai ,  p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' and l.idlab = '".$lab[0]->idlab."' order by b.nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai ,p.checkout1,p.checkin1, p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' and l.idlab = '".$lab[0]->idlab."' order by l.namaLab");
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
            $lab = DB::select("select DISTINCT la.idlab, la.namaLab, la.fakultas from lab la left join (select DISTINCT bd.lab as lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamlab  where idorder = '".$id."') lb on la.idlab = lb.lab left join laboran lc on lb.lab = lc.lab where user = '".auth()->user()->nrpnpk."'");
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp,p.checkout1,p.checkin1, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai ,  p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' and l.idlab = '".$request->lab."' order by b.nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai ,p.checkout1,p.checkin1, p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' and l.idlab = '".$request->lab."' order by l.namaLab");
            $keranjang = array();
            $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
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
            $pesanankubarang = DB::select("select p.sdosen,p.checkin1, p.checkout1, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' and l.idlab = '".$mylab."' order by b.nama");
            $pesanankulab = DB::select("select p.sdosen,p.checkin1, p.checkout1, p.skalab,l.idlab, l.namaLab,l.kapasitas, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' and p.idlab = '".$mylab."' order by l.namaLab");
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
                    $pinjam['checkin1'] = $pb->checkin1;
                    $pinjam['checkout1'] = $pb->checkout1;
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

                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] != "" || $pinjam['checkin1'] != ""|| $pinjam['skalab'] == 2 )
                    {}
                    else
                    { $keranjang[$pb->idbarangdetail] = $help; }
                    
                }
                else
                {
                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] != "" || $pinjam['checkin1'] != ""|| $pinjam['skalab'] == 2 )
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
                    $pinjam['checkin1'] = $pb->checkin1;
                    $pinjam['checkout1'] = $pb->checkout1;
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

                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] != "" || $pinjam['checkin1'] != ""|| $pinjam['skalab'] == 2 )
                    {}
                    else
                    { $keranjang[$pb->idlab] = $help1; }
                }
                else
                {
                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] != "" || $pinjam['checkin1'] != ""|| $pinjam['skalab'] == 2 )
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
                    $pesanankubarang = DB::select("select p.sdosen,p.checkin1, p.checkout1, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$cb."'");
                    foreach($pesanankubarang as $pb)
                    {
                        $cek = DB::select('select count(idp) as jumlah from pinjam where barang = "'.$pb->idbarangdetail.'"and checkin != "" and checkout1 = ""');
                        $pinjam['okay'] = $cek[0]->jumlah;
                        $pinjam['tgl'] = $pb->tanggal;
                        $pinjam['mulai'] = $pb->mulai;
                        $pinjam['selesai'] = $pb->selesai;
                        $pinjam['checkin'] = $pb->checkin;
                        $pinjam['checkout'] = $pb->checkout;
                        $pinjam['checkin1'] = $pb->checkin1;
                        $pinjam['checkout1'] = $pb->checkout1;
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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] != "" || $pinjam['checkin1'] != ""|| $pinjam['skalab'] == 2 )
                            {}
                            else
                            { $keranjang[$pb->idbarangdetail] = $help; }
                            
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] != "" || $pinjam['checkin1'] != ""|| $pinjam['skalab'] == 2 )
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
                    $pesanankulab = DB::select("select p.sdosen,p.checkin1, p.checkout1, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$cl."'");
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
                        $pinjam['checkin1'] = $pb->checkin1;
                        $pinjam['checkout1'] = $pb->checkout1;
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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] != "" || $pinjam['checkin1'] != ""|| $pinjam['skalab'] == 2 )
                            {}
                            else
                            { $keranjang[$pb->idlab] = $help; }
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] != "" || $pinjam['checkin1'] != ""|| $pinjam['skalab'] == 2 )
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

    public function ambildetail($id)
    {
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        if(KeranjangController::laborannya2($ambilin[0]->lab,auth()->user()->nrpnpk) == 0)
        {
            return redirect(url('/home'))->with("status",4);
        }
        else if(count($ambilin) > 0 || auth()->user()->jabatan == 9){
            $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');
            $orderku = Order::where('idorder',$ambilin[0]->order)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang,p.checkout1,p.checkin1, b.idbarangdetail, b.nama, p.idp, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.ambil = '".$id."' order by nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi,p.checkout1,p.checkin1, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.ambil = '".$id."' order by namaLab");
            $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
            $keranjang = array();
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
                    array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam);  
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

                     $keranjang[$pb->idlab] = $help; 
                    
                }
                else
                {   
                     array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); 
                }
            }
            return view('ambilbalik.ambildetail',compact('pemesan','dosenpj','keranjang','orderku','ambilin'));
        }
    }

    public function ambildetaildosen($id)
    {
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        $orderku = Order::where('idorder',$ambilin[0]->order)->get();
        if($orderku[0]->dosen != auth()->user()->nrpnpk)
        {
            return redirect(url('/order/detail/'.$ambilin[0]->order))->with("status",9);
        }
        else if(count($ambilin) > 0 || auth()->user()->jabatan == 9){
            // dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang,p.checkout1,p.checkin1, b.idbarangdetail, b.nama, p.idp, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.ambil = '".$id."' order by nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi,p.checkout1,p.checkin1, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.ambil = '".$id."' order by namaLab");
            $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
            $keranjang = array();
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
                    array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam);  
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

                     $keranjang[$pb->idlab] = $help; 
                    
                }
                else
                {   
                     array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); 
                }
            }
            $apa = "halo";
            return view('ambilbalik.ambildetail',compact('pemesan','dosenpj','keranjang','orderku','ambilin','apa'));
        }
    }

    public function finalambil(Request $request)
    {
        $id = $request->orderid;
        $helper = 0;
        $labdpl = "";
        $orderku = Order::where('idorder',$id)->get();
        if($request->ambilb != null){
            foreach($request->ambilb as $cb)
            {
                $pesanankubarang = DB::select("select p.sdosen,p.checkout1, p.checkin1, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi,l.idlab, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$cb."'");
                foreach($pesanankubarang as $pb)
                {
                    $labdpl =  $pb->idlab;
                    $cek = DB::select('select count(idp) as jumlah from pinjam where barang = "'.$pb->idbarangdetail.'"and checkin != "" and checkout1 = ""');
                    if($pb->sdosen != 1 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin != "" || $pb->checkout1 != "" || $pb->checkin1 != "" || $pb->skalab != 1 )
                    { $helper++; }
                }
            }
        }
        if($request->ambill != null) {
            foreach($request->ambill as $cl)
            {
                $pesanankulab = DB::select("select p.sdosen,p.checkout1, p.checkin1, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$cl."'");
                foreach($pesanankulab as $pb)
                {
                    $labdpl =  $pb->idlab;
                    if($pb->sdosen != 1 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin != "" || $pb->checkout1 != "" || $pb->checkin1 != "" || $pb->skalab != 1 )
                    { $helper++; }
                }
            }
        }
        if($helper >= 1)
        {
            return redirect('/ambil/all/'.$id)->with('status', '1');
        }
        else{
            
            $ket = "";
            $jumlah = DB::select("select count(a.idambilbalik) as jumlah from ambilbalik a where a.order = '".$id."'");
            $idab = $id.str_pad($jumlah[0]->jumlah+1 ,3,"0",STR_PAD_LEFT);
            $ambilin = new Ambilbalik;
            $ambilin->idambilbalik = $idab;
            $ambilin->order = $id;
            $ambilin->note = $request->pesan;
            $ambilin->abcode = $request->kodep;
            $ambilin->tipe = "AMBIL";
            $ambilin->time = date("Y-m-d H:i:s");
            $ambilin->PIC = auth()->user()->nrpnpk;
            $ambilin->lab = $labdpl;
            $ambilin->save();

            if($request->ambilb != null){
                foreach($request->ambilb as $k=>$cb)
                {
                    //dd("update pinjam set checkin = now(), ambil = '".$idab."' where idp = '".$cb."'");
                    DB::statement("update pinjam set checkin = now(), ambil = '".$idab."' where idp = '".$cb."'");
                    $ket.= KeranjangController::itemname($k). " | ";
                }
            }
            if($request->ambill != null) {
                foreach($request->ambill as $k=>$cl)
                {
                   DB::statement("update pinjamlab set checkin = now() , ambil = '".$idab."' where idpl = '".$cl."'");
                   $ket.= KeranjangController::labname($k). " | ";
                }
            }

            $riwayat = new History;
            $riwayat->status = 7;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->pic =auth()->user()->nrpnpk;
            $riwayat->order = $id;
            $riwayat->keterangan = $ket;
            $riwayat->save();
            keranjangController::kirimemaila($idab);
            return redirect('/order/detail/'.$id)->with('status', '5');
        }
        
    }

    public function gantiambilfinal(Request $request)
    {
        $id = $request->idambilbalik;
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        $helper = 0;
        $ket = "";
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');
        $orderku = Order::where('idorder',$ambilin[0]->order)->get();
        if($request->setujub != null){
            foreach($request->setujub as $k=>$cb)
            {
                $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi,l.idlab, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$k."'");
                foreach($pesanankubarang as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin == "" || $pb->skalab == 2 )
                    { 
                       $helper++; 
                    }
                }
            }
        }
        if($request->setujul != null) {
            foreach($request->setujul as $k=>$cl)
            {
                $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$k."'");
                foreach($pesanankulab as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin == "" || $pb->skalab == 2 )
                    {
                        $helper++; 
                    }    
                }
            }
        }

        if($helper >= 1)
        {
            return redirect('/ambil/detail/'.$id)->with('status', '1');
        }
        else{
            DB::statement("update .order set noteKalab = '".$request->pesan."' where idorder = '".$id."'");
            if($request->setujub != null){
                foreach($request->setujub as $k=>$cb)
                {
                    if($cb == 1)
                    {
                        DB::statement("update pinjam set checkin1 = now() where idp = '".$k."'");
                        $ket.= KeranjangController::itemname($cb). " (Item Diambil) | ";
                    }
                    else if($cb == 2)
                    {
                        DB::statement("update pinjam set checkout1 = now(),keterangan = 'Item Tidak Diambil Oleh Pemesan' where idp = '".$k."'");
                        $ket.= KeranjangController::itemname($cb). " (Item Tidak Diambil) | ";
                    }
                    else if($cb == 3)
                    {
                        DB::statement("update pinjam set ambil = null ,checkin = null where idp = '".$k."'");
                        $ket.= KeranjangController::itemname($cb). " (Pengambilan Dibatalkan) | ";
                    }
                }
            }
            if($request->setujul != null) {
                foreach($request->setujul as $k=>$cl)
                {
                    if($cl == 1)
                    {
                        DB::statement("update pinjamlab set checkin1 = now() where idpl = '".$k."'");
                        $ket.= KeranjangController::labname($cl). " (Pemesan Hadir) | ";
                    }
                    else if($cl == 2)
                    {
                        DB::statement("update pinjamlab set checkout1 = now(),keterangan = 'Pemesan Tidak Hadir' where idp1 = '".$k."'");
                        $ket.= KeranjangController::labname($cl). " (Pemesan Tidak Hadir) | ";
                    }
                    else if($cl == 1)
                    {
                        DB::statement("update pinjamlab set ambil = null ,checkin = null where idpl = '".$k."'");
                        $ket.= KeranjangController::labname($cl). " (Kehadiran Dibatalkan) | ";
                    }
                }
            }

            $riwayat = new History;
            $riwayat->status = 12;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->pic =auth()->user()->nrpnpk;
            $riwayat->keterangan = $ket;
            $riwayat->order = $ambilin[0]->order;
            $riwayat->save();
            KeranjangController::kirimemail($ambilin[0]->order,'Perubahan Data Pengambilan Barang / Kehadiran','Perubahan Data Pengambilan Barang / Kehadiran'.$id,'Perubahan Data Pengambilan Barang / Kehadiran Dari Pesanan Yang Berkaitan Dengan Anda','Perubahan Data Pengambilan Barang / Kehadiran Dari Pesanan Yang Berkaitan Dengan Anda'.$id,'ambil');
            return redirect('/order/detail/'.$ambilin[0]->order)->with('status', '6');
        }
    }

    public function gantiambil(Request $request)
    {
        $id = $request->idambilbalik;
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        $keranjang = array();
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');

            $orderku = Order::where('idorder',$ambilin[0]->order)->get();
            if($request->setujub != null){
                foreach($request->setujub as $k=>$cb)
                {
                    $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.lab, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$k."'");
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
                        $pinjam['setuju'] = $cb;
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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] == "" || $pinjam['skalab'] == 2 || $cb == 0)
                            {}
                            else
                            { 
                                foreach($laboran as $la)
                                {
                                    if($pb->lab == $la->lab)
                                    {$keranjang[$pb->idbarangdetail] = $help;  }
                                }
                            }        
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] == "" || $pinjam['skalab'] == 2 || $cb == 0)
                            {}
                            else
                            { 
                                foreach($laboran as $la)
                                {
                                    if($pb->lab == $la->lab)
                                    { array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam);  }
                                }
                            }
                        }
                    }
                }
            }
            if($request->setujul != null) {
                foreach($request->setujul as $k=>$cl)
                {
                    $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi,l.idlab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$k."'");
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
                        $pinjam['setuju'] = $cl;
                        if(!isset($keranjang[$pb->idlab]))
                        {
                            $help1['id'] = $pb->idlab;
                            $help1['nama'] = $pb->namaLab;
                            $help1['lokasi'] = $pb->lokasi;
                            $help1['gambar'] = PinjamLabController::gambar($pb->idlab);
                            $help1['pinjam'] = array($pinjam);
                            $help1['fakultas'] = $pb->fakultas;
                            $help1['tipe'] = "lab";

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] == "" || $pinjam['skalab'] == 2 || $cl == 0)
                            {}
                            else
                            { 
                                foreach($laboran as $la)
                                {
                                    if($pb->idlab == $la->lab)
                                    {  $keranjang[$pb->idlab] = $help1;    }
                                }
                            }
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] == "" || $pinjam['skalab'] == 2 || $cl == 0)
                            {}
                            else
                            { 
                                foreach($laboran as $la)
                                {
                                    if($pb->idlab == $la->lab)
                                    {  array_push($keranjang[$pb->idlab]['pinjam'],$pinjam);   }
                                }
                            }
                        }
                    }
                }
            }
        
        //dd($keranjang);
        if(count($keranjang) == 0)
        {
            return redirect('/ambil/detail/'.$id)->with('status', '2');
           //echo "nol";
        }
        else{
            $pesan = $request->pesan;
            return view("ambilbalik.konfirmasiambil2",compact('orderku','keranjang','pesan','ambilin'));
        }
    }

    public function konfirmasiambil(Request $request)
    {
        $id = $request->idorder;
        $ambilin = Ambilbalik::where('order',$id)->where('abcode',$request->acode)->get();
        if(count($ambilin) == 0 || $ambilin[0]->time2 != "")
        {
            return redirect(url('/order/detail/'.$request->idorder))->with("status",7);
        }
        else if(count($ambilin) > 0 || auth()->user()->jabatan == 9){
            $id = $ambilin[0]->idambilbalik;
            $orderku = Order::where('idorder',$ambilin[0]->order)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang,p.checkout1,p.checkin1, b.idbarangdetail, b.nama, p.idp, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.ambil = '".$id."' order by nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi,p.checkout1,p.checkin1, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.ambil = '".$id."' order by namaLab");
            $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
            $keranjang = array();
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
                    
                        $keranjang[$pb->idbarangdetail] = $help;
                    
                }
                else
                {
                    array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam);  
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

                     $keranjang[$pb->idlab] = $help; 
                    
                }
                else
                {   
                     array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); 
                }
            }
            return view('ambilbalik.konfirmasipemesan',compact('pemesan','dosenpj','keranjang','orderku','ambilin'));
        }
    }

    public function konfirmasipemesanfinal(Request $request)
    {
        DB::statement("update pinjam set checkin1 = now() where ambil = '".$request->idambilbalik."'");
        DB::statement("update pinjamlab set checkin1 = now() where ambil = '".$request->idambilbalik."'");
        DB::statement("update ambilbalik set time2 = now() where idambilbalik = '".$request->idambilbalik."'");
        $riwayat = new History;
        $riwayat->status = 13;
        $riwayat->tanggal = date("Y-m-d H:i:s");
        $riwayat->PIC =auth()->user()->nrpnpk;
        $riwayat->order = $request->orderid;
        $riwayat->save();
        KeranjangController::kirimemail($request->orderid,'Pengambilan Item / Kehadiran Telah Dikonfirmasi Oleh Pemesan','Pengambilan Item / Kehadiran Telah Dikonfirmasi Oleh Pemesan','Pengambilan Item / Kehadiran Telah Dikonfirmasi Oleh Pemesan (Pesanan Yang Berkaitan Dengan Anda)','Pengambilan Item / Kehadiran Telah Dikonfirmasi Oleh Pemesan (Pesanan Yang Berkaitan Dengan Anda)','ambil');
        return redirect('/order/detail/'.$request->orderid)->with('status', '8');
    
    }

    public function balik($id)
    {
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');
        $order = Order::where('idorder',$id)->get();
        if($order[0]->mahasiswa != auth()->user()->nrpnpk)
        {
            return redirect(url('/home'))->with("status",4);
        }
        else{

            
            $lab = DB::select("select DISTINCT la.idlab, la.namaLab, la.fakultas from lab la left join (select DISTINCT bd.lab as lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamlab  where idorder = '".$id."') lb on la.idlab = lb.lab left join laboran lc on lb.lab = lc.lab");
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp,p.checkout1,p.checkin1, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai ,  p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' and l.idlab = '".$lab[0]->idlab."' order by b.nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai ,p.checkout1,p.checkin1, p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' and l.idlab = '".$lab[0]->idlab."' order by l.namaLab");
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
                    
                       
                        $keranjang[$pb->idbarangdetail] = $help;
                    
                }
                else
                {
                   
                      
                        { array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam); }
                    
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

                 
                       
                        { $keranjang[$pb->idlab] = $help; }
                    
                }
                else
                {   
                   
                       
                      { array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); } 
                    
                }
            }
            $labdpl = $lab[0]->idlab;
           // dd($keranjang);
            return view('ambilbalik.balik',compact('pemesan','dosenpj','lab','orderku','keranjang','labdpl'));
        }
    }

    public function prosesbalik(Request $request)
    {
        $id = $request->orderid;
        $mylab = $request->labdpl;
        $keranjang = array();
      
        if(isset($request->ambilall))
        {   
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $pesanankubarang = DB::select("select p.sdosen,p.checkin1, p.checkout1, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' and l.idlab = '".$mylab."' order by b.nama");
            $pesanankulab = DB::select("select p.sdosen,p.checkin1, p.checkout1, p.skalab,l.idlab, l.namaLab,l.kapasitas, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' and p.idlab = '".$mylab."' order by l.namaLab");
            $penampung = "";
            foreach($pesanankubarang as $pb)
            {
                    $pinjam['tgl'] = $pb->tanggal;
                    $pinjam['mulai'] = $pb->mulai;
                    $pinjam['selesai'] = $pb->selesai;
                    $pinjam['checkin'] = $pb->checkin;
                    $pinjam['checkout'] = $pb->checkout;
                    $pinjam['checkin1'] = $pb->checkin1;
                    $pinjam['checkout1'] = $pb->checkout1;
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

                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" || $pinjam['checkin1'] == ""|| $pinjam['skalab'] == 2 )
                    {}
                    else
                    { $keranjang[$pb->idbarangdetail] = $help; }
                    
                }
                else
                {
                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" ||  $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" ||  $pinjam['checkin1'] == ""||  $pinjam['skalab'] == 2 )
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
                    $pinjam['checkin1'] = $pb->checkin1;
                    $pinjam['checkout1'] = $pb->checkout1;
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

                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" ||  $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" ||  $pinjam['checkin1'] == ""||  $pinjam['skalab'] == 2 )
                    {}
                    else
                    { $keranjang[$pb->idlab] = $help1; }
                }
                else
                {
                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" ||  $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" ||  $pinjam['checkin1'] == ""||  $pinjam['skalab'] == 2 )
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
                    $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang,p.checkin1, p.checkout1, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$cb."'");
                    foreach($pesanankubarang as $pb)
                    {
                        $pinjam['tgl'] = $pb->tanggal;
                        $pinjam['mulai'] = $pb->mulai;
                        $pinjam['selesai'] = $pb->selesai;
                        $pinjam['checkin'] = $pb->checkin;
                        $pinjam['checkout'] = $pb->checkout;
                        $pinjam['checkin1'] = $pb->checkin1;
                        $pinjam['checkout1'] = $pb->checkout1;
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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" ||  $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" ||  $pinjam['checkin1'] == ""||  $pinjam['skalab'] == 2 )
                            {}
                            else
                            { $keranjang[$pb->idbarangdetail] = $help; }
                            
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" ||  $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" ||  $pinjam['checkin1'] == ""||  $pinjam['skalab'] == 2 )
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
                    $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.checkin1, p.checkout1, p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$cl."'");
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
                        $pinjam['checkin1'] = $pb->checkin1;
                        $pinjam['checkout1'] = $pb->checkout1;
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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" ||  $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" ||  $pinjam['checkin1'] == ""||  $pinjam['skalab'] == 2 )
                            {}
                            else
                            { $keranjang[$pb->idlab] = $help; }
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" ||  $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" ||  $pinjam['checkin1'] == ""||  $pinjam['skalab'] == 2 )
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
            return redirect('/balik/all/'.$id)->with('status', '2');
        }
        else{
            return view("ambilbalik.konfirmasibalik",compact('orderku','keranjang'));
        }
    }

    public function finalbalik(Request $request)
    {
        $id = $request->orderid;
        $helper = 0;
        $labdpl = "";
        $orderku = Order::where('idorder',$id)->get();
        if($request->ambilb != null){
            foreach($request->ambilb as $cb)
            {
                $pesanankubarang = DB::select("select p.sdosen,p.checkout1, p.checkin1, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi,l.idlab, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$cb."'");
                foreach($pesanankubarang as $pb)
                {
                    $labdpl =  $pb->idlab;
                    if($pb->sdosen != 1 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin == "" || $pb->checkout1 != "" || $pb->checkin1 == "" || $pb->skalab != 1 )
                    { $helper++; }
                }
            }
        }
        if($request->ambill != null) {
            foreach($request->ambill as $cl)
            {
                $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab,p.checkout1, p.checkin1, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$cl."'");
                foreach($pesanankulab as $pb)
                {
                    $labdpl =  $pb->idlab;
                    if($pb->sdosen != 1 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin == "" || $pb->checkout1 != "" || $pb->checkin1 == "" || $pb->skalab != 1 )
                    { $helper++; }
                }
            }
        }
        if($helper >= 1)
        {
            return redirect('/balik/all/'.$id)->with('status', '1');
            //echo "nol";
        }
        else{
            
            $jumlah = DB::select("select count(a.idambilbalik) as jumlah from ambilbalik a where a.order = '".$id."'");
            $idab = $id.str_pad($jumlah[0]->jumlah+1 ,3,"0",STR_PAD_LEFT);
            $ambilin = new Ambilbalik;
            $ambilin->idambilbalik = $idab;
            $ambilin->order = $id;
            $ambilin->note = $request->pesan;
            $ambilin->abcode = $request->kodep;
            $ambilin->tipe = "BALIK";
            $ambilin->time = date("Y-m-d H:i:s");
            $ambilin->PIC = auth()->user()->nrpnpk;
            $ambilin->lab = $labdpl;
            $ambilin->save();

            if($request->ambilb != null){
                foreach($request->ambilb as $cb)
                {
                    //dd("update pinjam set checkin = now(), ambil = '".$idab."' where idp = '".$cb."'");
                    DB::statement("update pinjam set checkout = now(), balik = '".$idab."' where idp = '".$cb."'");
                }
            }
            if($request->ambill != null) {
                foreach($request->ambill as $cl)
                {
                   DB::statement("update pinjamlab set checkout = now() , balik = '".$idab."' where idpl = '".$cl."'");
                }
            }

            $riwayat = new History;
            $riwayat->status = 14;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->PIC =auth()->user()->nrpnpk;
            $riwayat->order = $id;
            $riwayat->save();
           keranjangController::kirimemailb($idab);
            return redirect('/order/detail/'.$id)->with('status', '10');
        }
        
    }

    public function balikdetailmhs($id)
    {
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        $orderku = Order::where('idorder',$ambilin[0]->order)->get();
        if($orderku[0]->mahasiswa != auth()->user()->nrpnpk)
        {
            return redirect(url('/order/detail/'.$ambilin[0]->order))->with("status",9);
        }
        else if(count($ambilin) > 0 || auth()->user()->jabatan == 9){
            // dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang,p.checkout1,p.checkin1, b.idbarangdetail, b.nama, p.idp, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.balik = '".$id."' order by nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi,p.checkout1,p.checkin1, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.balik = '".$id."' order by namaLab");
            $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
            $keranjang = array();
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
                    array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam);  
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

                     $keranjang[$pb->idlab] = $help; 
                    
                }
                else
                {   
                     array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); 
                }
            }
            $apa = "mhs";
            return view('ambilbalik.balikdetailmhs',compact('pemesan','dosenpj','keranjang','orderku','ambilin','apa'));
        }
    }

    public function prosesmhs(Request $request)
    {
        $id = $request->idambilbalik;
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        $keranjang = array();
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');
        //dd($request->balikl);
            $orderku = Order::where('idorder',$ambilin[0]->order)->get();
            if($request->balikb != null){
                foreach($request->balikb as $k=>$cb)
                {
                    $pesanankubarang = DB::select("select p.sdosen,p.checkout1, p.checkin1, p.skalab,k.nama as kategori, br.nama as namaBarang, b.lab, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$k."'");
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
                        $pinjam['checkout1'] = $pb->checkout1;
                        $pinjam['checkin1'] = $pb->checkin1;

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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['status'] == 3 || $pinjam['checkout'] == "" || $pinjam['checkin'] == ""  || $pinjam['checkout1'] != "" || $pinjam['checkin1'] == "" || $pinjam['skalab'] == 2 )
                            {}
                            else
                            { 
                                if($orderku[0]->mahasiswa == auth()->user()->nrpnpk)
                                { $keranjang[$pb->idbarangdetail] = $help;  }
                            }        
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['status'] == 3 || $pinjam['checkout'] == "" || $pinjam['checkin'] == ""  || $pinjam['checkout1'] != "" || $pinjam['checkin1'] == "" || $pinjam['skalab'] == 2 )
                            {}
                            else
                            { 
                                if($orderku[0]->mahasiswa == auth()->user()->nrpnpk)
                                    { array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam);  }
                                
                            }
                        }
                    }
                }
            }
            if($request->balikl != null) {
                foreach($request->balikl as $k=>$cl)
                {
                    $pesanankulab = DB::select("select p.sdosen,p.checkout1, p.checkin1, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi,l.idlab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$k."'");
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
                        $pinjam['checkout1'] = $pb->checkout1;
                        $pinjam['checkin1'] = $pb->checkin1;

                        if(!isset($keranjang[$pb->idlab]))
                        {
                            $help1['id'] = $pb->idlab;
                            $help1['nama'] = $pb->namaLab;
                            $help1['lokasi'] = $pb->lokasi;
                            $help1['gambar'] = PinjamLabController::gambar($pb->idlab);
                            $help1['pinjam'] = array($pinjam);
                            $help1['fakultas'] = $pb->fakultas;
                            $help1['tipe'] = "lab";

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['status'] == 3 || $pinjam['checkout'] == "" || $pinjam['checkin'] == ""  || $pinjam['checkout1'] != "" || $pinjam['checkin1'] == "" || $pinjam['skalab'] == 2 )
                            {}
                            else
                            { 
                                if($orderku[0]->mahasiswa == auth()->user()->nrpnpk)
                                    {  $keranjang[$pb->idlab] = $help1;    }
                                
                            }
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['status'] == 3 || $pinjam['checkout'] == "" || $pinjam['checkin'] == ""  || $pinjam['checkout1'] != "" || $pinjam['checkin1'] == "" || $pinjam['skalab'] == 2 )
                            {}
                            else
                            { 
                                if($orderku[0]->mahasiswa == auth()->user()->nrpnpk)
                                    {  array_push($keranjang[$pb->idlab]['pinjam'],$pinjam);   }
                                
                            }
                        }
                    }
                }
            }
        
        //dd($keranjang);
        if(count($keranjang) == 0)
        {
            return redirect('/balik/balikdetailmhs/'.$id)->with('status', '2');
           //echo "nol";
        }
        else{
            $pesan = $request->pesan;
            return view("ambilbalik.konfirmasibalikmhs",compact('orderku','keranjang','pesan','ambilin'));
        }
    }

    public function gantibalikfinalmhs(Request $request)
    {
        $id = $request->idambilbalik;
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        $helper = 0;
        $ket = "";
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');
        $orderku = Order::where('idorder',$ambilin[0]->order)->get();
        if($request->balikb != null){
            foreach($request->balikb as $k=>$cb)
            {
                $pesanankubarang = DB::select("select p.checkout1, p.checkin1, p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi,l.idlab, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$k."'");
                foreach($pesanankubarang as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout == "" || $pb->checkin == "" || $pb->checkout1 != "" || $pb->checkin1 == "" || $pb->skalab == 2 )
                    { 
                       $helper++; 
                    }
                }
            }
        }
        if($request->balikl != null) {
            foreach($request->balikl as $k=>$cl)
            {
                $pesanankulab = DB::select("select p.checkin1, p.checkout1, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$k."'");
                foreach($pesanankulab as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout == "" || $pb->checkin == "" || $pb->checkout1 != "" || $pb->checkin1 == "" || $pb->skalab == 2 )
                    {
                        $helper++; 
                    }    
                }
            }
        }

        if($helper >= 1)
        {
            return redirect('/ambil/detail/'.$id)->with('status', '1');
        }
        else{
            DB::statement("update .order set noteKalab = '".$request->pesan."' where idorder = '".$id."'");
            if($request->balikb != null){
                foreach($request->balikb as $k=>$cb)
                {
                    DB::statement("update pinjam set balik = null ,checkout = null where idp = '".$k."'");
                    $ket.= KeranjangController::itemname($k). " (Pengembalian Dibatalkan) | ";
                }
            }
            if($request->balikl != null) {
                foreach($request->balikl as $k=>$cl)
                {
                
                    DB::statement("update pinjamlab set balik = null ,checkout = null where idpl = '".$k."'");
                    $ket.= KeranjangController::labname($k). " (Kehadiran Keluar Dibatalkan) | ";
                    
                }
            }

            $riwayat = new History;
            $riwayat->status = 15;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->PIC =auth()->user()->nrpnpk;
            $riwayat->order = $ambilin[0]->order;
            $riwayat->keterangan = $ket;
            $riwayat->save();
            KeranjangController::kirimemail($ambilin[0]->order,'Pemesan Membatalkan Pengembalian Barang / Kehadiran Keluar','Pemesan Membatalkan Pengembalian Barang / Kehadiran Keluar','Pemesann Membatalkan Pengembalian Barang / Kehadiran Keluar Dari Pesanan Yang Berkaitan Dengan Anda','Pemesann Membatalkan Pengembalian Barang / Kehadiran Keluar Dari Pesanan Yang Berkaitan Dengan Anda','ambil');
             return redirect('/order/detail/'.$ambilin[0]->order)->with('status', '6');
        }
    }

    public function balikdetaildsn($id)
    {
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        $orderku = Order::where('idorder',$ambilin[0]->order)->get();
        if($orderku[0]->dosen != auth()->user()->nrpnpk)
        {
            return redirect(url('/order/detail/'.$ambilin[0]->order))->with("status",9);
        }
        else if(count($ambilin) > 0 || auth()->user()->jabatan == 9){
            // dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang,p.checkout1,p.checkin1, b.idbarangdetail, b.nama, p.idp, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.balik = '".$id."' order by nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi,p.checkout1,p.checkin1, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.balik = '".$id."' order by namaLab");
            $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
            $keranjang = array();
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
                    array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam);  
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

                     $keranjang[$pb->idlab] = $help; 
                    
                }
                else
                {   
                     array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); 
                }
            }
            $apa = "mhs";
            return view('ambilbalik.balikdetaildsn',compact('pemesan','dosenpj','keranjang','orderku','ambilin','apa'));
        }
    }

    public function balikdetaillab($id)
    {
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        $orderku = Order::where('idorder',$ambilin[0]->order)->get();
        if($orderku[0]->dosen != auth()->user()->nrpnpk)
        {
            return redirect(url('/order/detail/'.$ambilin[0]->order))->with("status",9);
        }
        else if(count($ambilin) > 0 || auth()->user()->jabatan == 9){
            // dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang,p.checkout1,p.checkin1, b.idbarangdetail, b.nama, p.idp, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.balik = '".$id."' order by nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi,p.checkout1,p.checkin1, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.balik = '".$id."' order by namaLab");
            $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
            $keranjang = array();
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
                    array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam);  
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

                     $keranjang[$pb->idlab] = $help; 
                    
                }
                else
                {   
                     array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); 
                }
            }
            $apa = "mhs";
            return view('ambilbalik.balikdetaillab',compact('pemesan','dosenpj','keranjang','orderku','ambilin','apa'));
        }
    }

    public function proseslab(Request $request)
    {
        $id = $request->idambilbalik;
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        $mylab = $request->labdpl;
        $keranjang = array();
        $pesan = $request->pesan;

            $orderku = Order::where('idorder',$ambilin[0]->order)->get();
            if($request->diambilb != null){
                foreach($request->diambilb as $k=>$cb)
                {
                    $pesanankubarang = DB::select("select p.sdosen,p.checkin1, p.checkout1, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$k."'");
                    foreach($pesanankubarang as $pb)
                    {
                        $cek = DB::select('select count(idp) as jumlah from pinjam where barang = "'.$pb->idbarangdetail.'"and checkin != "" and checkout1 = ""');
                        $pinjam['okay'] = $cek[0]->jumlah;
                        $pinjam['tgl'] = $pb->tanggal;
                        $pinjam['mulai'] = $pb->mulai;
                        $pinjam['selesai'] = $pb->selesai;
                        $pinjam['checkin'] = $pb->checkin;
                        $pinjam['checkout'] = $pb->checkout;
                        $pinjam['checkin1'] = $pb->checkin1;
                        $pinjam['checkout1'] = $pb->checkout1;
                        $pinjam['idp'] = $pb->idp;
                        $pinjam['statusDosen'] = $pb->statusDosen;
                        if(isset($request->masl[$k])) { $pinjam['masalah'] = $request->masl[$k]; }
                        else { $pinjam['masalah'] = $pb->masalah; }
                        $pinjam['statusKalab'] = $pb->statusKalab;
                        $pinjam['keterangan'] = $pb->keterangan;
                        $pinjam['status'] = $pb->status;
                        $pinjam['sdosen'] = $pb->sdosen;
                        $pinjam['skalab'] = $pb->skalab;
                        $pinjam['balik'] = $cb;

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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] == "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" || $pinjam['checkin1'] == ""|| $pinjam['skalab'] == 2 || $cb ==0)
                            {}
                            else
                            { $keranjang[$pb->idbarangdetail] = $help; }
                            
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] == "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" || $pinjam['checkin1'] == ""|| $pinjam['skalab'] == 2 || $cb ==0)
                            {}
                            else
                            { array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam); }
                        }
                    }
                }
            }
            if($request->diambill != null) {
                foreach($request->diambill as $k=>$cl)
                {
                    $pesanankulab = DB::select("select p.sdosen,p.checkin1, p.checkout1, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$k."'");
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
                        $pinjam['checkin1'] = $pb->checkin1;
                        $pinjam['checkout1'] = $pb->checkout1;
                        $pinjam['idpl'] = $pb->idpl;
                        $pinjam['statusDosen'] = $pb->statusDosen;
                        if(isset($request->masl[$k])) { $pinjam['masalah'] = $request->masl[$k]; }
                        else {$pinjam['masalah'] = $pb->masalah;}
                        $pinjam['statusKalab'] = $pb->statusKalab;
                        $pinjam['keterangan'] = $pb->keterangan;
                        $pinjam['status'] = $pb->status;
                        $pinjam['sdosen'] = $pb->sdosen;
                        $pinjam['skalab'] = $pb->skalab;
                        $pinjam['balik'] = $cl;
                        if(!isset($keranjang[$pb->idlab]))
                        {
                            $help['id'] = $pb->idlab;
                            $help['nama'] = $pb->namaLab;
                            $help['lokasi'] = $pb->lokasi;
                            $help['gambar'] = PinjamLabController::gambar($pb->idlab);
                            $help['pinjam'] = array($pinjam);
                            $help['fakultas'] = $pb->fakultas;
                            $help['tipe'] = "lab";

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] == "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" || $pinjam['checkin1'] == ""|| $pinjam['skalab'] == 2 || $cl ==0)
                            {}
                            else
                            { $keranjang[$pb->idlab] = $help; }
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] == "" || $pinjam['checkout1'] != "" || $pinjam['checkin'] == "" || $pinjam['checkin1'] == ""|| $pinjam['skalab'] == 2 || $cl ==0)
                            {}
                            else
                            { array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); }
                        }
                    }
                }
            }
        
        if(count($keranjang) == 0)
        {
            return redirect('/balik/balikdetaillab/'.$id)->with('status', '2');
        }
        else{
            return view("ambilbalik.konfirmasibaliklab",compact('orderku','keranjang','pesan','ambilin'));
        }
    }

    public function gantibalikfinallab(Request $request)
    {
        //dd($request->masl);
        $id = $request->idambilbalik;
        $ambilin = Ambilbalik::where('idambilbalik',$id)->get();
        $helper = 0;
        $ket = "";
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');
        $orderku = Order::where('idorder',$ambilin[0]->order)->get();
        if($request->balikb != null){
            foreach($request->balikb as $k=>$cb)
            {
                $pesanankubarang = DB::select("select p.checkout1, p.checkin1, p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi,l.idlab, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$k."'");
                foreach($pesanankubarang as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout == "" || $pb->checkin == "" || $pb->checkout1 != "" || $pb->checkin1 == "" || $pb->skalab == 2 )
                    { 
                       $helper++; 
                    }
                }
            }
        }
        if($request->balikl != null) {
            foreach($request->balikl as $k=>$cl)
            {
                $pesanankulab = DB::select("select p.checkin1, p.checkout1, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$k."'");
                foreach($pesanankulab as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout == "" || $pb->checkin == "" || $pb->checkout1 != "" || $pb->checkin1 == "" || $pb->skalab == 2 )
                    {
                        $helper++; 
                    }    
                }
            }
        }

        if($helper >= 1)
        {
            return redirect('/ambil/detail/'.$id)->with('status', '1');
        }
        else{
            DB::statement("update .order set noteKalab = '".$request->pesan."' where idorder = '".$id."'");
            if($request->balikb != null){
                foreach($request->balikb as $k=>$cb)
                {
                    if($cb == 1)
                    {
                        DB::statement("update pinjam set checkout1 = now() where idp = '".$k."'");
                        $ket.= KeranjangController::itemname($k). " (Pengembalian Dikonfirmasi) | ";
                    }
                    else if ($cb ==2)
                    {
                        DB::statement("update pinjam set status = 3 , masalah = '".$request->masb[$k]."' where idp = '".$k."'");
                        $ket.= KeranjangController::itemname($k). " (Terjadi Permasalahan) | ";
                    }
                    else if ($cb ==4)
                    {
                        DB::statement("update pinjam set status = 1 , masalah = '".$request->masb[$k]."' , checkout1 = now() where idp = '".$k."'");
                        $ket.= KeranjangController::itemname($k). " (Permasalahan Selesai) | ";
                    }
                    else if ($cb ==5)
                    {
                        DB::statement("update pinjam set status = 1 , masalah = ''  where idp = '".$k."'");
                        $ket.= KeranjangController::itemname($k). " (Permasalahan Dibatalkan) | ";
                    }
                    
                }
            }
            if($request->balikl != null) {
                foreach($request->balikl as $k=>$cl)
                {
                    if($cl == 1)
                    {
                        DB::statement("update pinjamlab set checkout1 = now() where idpl = '".$k."'");
                        $ket.= KeranjangController::itemname($k). " (Kehadiran Keluar Dikonfirmasi) | ";
                    }
                    else if ($cl == 2)
                    {
                        DB::statement("update pinjamlab set status = 3 , masalah = '".$request->masl[$k]."' where idpl = '".$k."'");
                        $ket.= KeranjangController::itemname($k). " (Terjadi Permasalahan) | ";
                    }
                    else if ($cl ==4)
                    {
                        DB::statement("update pinjamlab set status = 1 , masalah = '".$request->masl[$k]."' , checkout1 = now() where idpl = '".$k."'");
                        $ket.= KeranjangController::itemname($k). " (Permasalahan Selesai) | ";
                    }
                    else if ($cl ==5)
                    {
                        DB::statement("update pinjamlab set status = 1 , masalah = ''  where idpl = '".$k."'");
                        $ket.= KeranjangController::itemname($k). " (Permasalahan Dibatalkan) | ";
                    }
                    
                }
            }

            $this->matikan($ambilin[0]->order);
            $riwayat = new History;
            $riwayat->status = 16;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->PIC =auth()->user()->nrpnpk;
            $riwayat->order = $ambilin[0]->order;
            $riwayat->keterangan = $ket;
            $riwayat->save();
            KeranjangController::kirimemail($ambilin[0]->order,'Pengembalian Barang / Kehadiran Keluar Mendapat Tanggapan Dari Kalab / Laboran','Pengembalian Barang / Kehadiran Keluar Mendapat Tanggapan Dari Kalab / Laboran','Pengembalian Barang / Kehadiran Keluar Dari Pesanan Yang Berkaitan Dengan Anda Mendapat Tanggapan Dari Kalab / Laboran','Pengembalian Barang / Kehadiran Keluar Dari Pesanan Yang Berkaitan Dengan Anda Mendapat Tanggapan Dari Kalab / Laboran','ambil');
             return redirect('/order/detail/'.$ambilin[0]->order)->with('status', '12');
        }
    }

    public function matikan($orderid)
    {
        $helper = 0;
        $orderku = Order::where('idorder',$orderid)->get();// dd($orderku);
        $pesanankubarang = DB::select("select p.checkout1, p.sdosen, p.skalab, p.idp, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$orderid."' order by b.nama");
        $pesanankulab = DB::select("select p.checkout1, p.sdosen, p.skalab,l.idlab, p.idpl, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamlab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$orderid."' order by l.namaLab");
        foreach($pesanankubarang as $pb)
        {
            if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout1 != "" || $pb->skalab == 2 )
            { $helper++; }
        }
        foreach($pesanankulab as $pb)
        {
            if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout1 != "" || $pb->skalab == 2 )
            { $helper++; }
        }

        if($helper == (count($pesanankubarang)+count($pesanankulab)))
        {
            DB::statement("update .order  set status = 1 where idorder = '".$orderid."'");
            $riwayat = new History;
            $riwayat->status = 4;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->PIC ='020102000';
            $riwayat->order = $orderid;
            $riwayat->save();
            return 1;
        }
        else { return 0; }
    }
}
