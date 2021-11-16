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
        else{
            $lab = DB::select("select DISTINCT la.idlab, la.namaLab, la.fakultas from lab la left join (select DISTINCT bd.lab as lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.idlab = lb.lab left join laboran lc on lb.lab = lc.lab where user = '".auth()->user()->nrpnpk."'");
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai ,  p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' and l.idlab = '".$lab[0]->idlab."' order by b.nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' and l.idlab = '".$lab[0]->idlab."' order by l.namaLab");
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

            return view('ambilbalik.ambil',compact('pemesan','dosenpj','lab','orderku','keranjang'));
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
        else{
            $lab = DB::select("select DISTINCT la.idlab, la.namaLab, la.fakultas from lab la left join (select DISTINCT bd.lab as lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.idlab = lb.lab left join laboran lc on lb.lab = lc.lab where user = '".auth()->user()->nrpnpk."'");
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai ,  p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' and l.idlab = '".$request->lab."' order by b.nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' and l.idlab = '".$request->lab."' order by l.namaLab");
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
            return view('ambilbalik.ambil',compact('pemesan','dosenpj','lab','orderku','keranjang'));
        }
    }
}
