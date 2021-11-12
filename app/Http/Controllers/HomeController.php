<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;
use App\Models\Jurusan;
use App\Models\Fakultas;
use App\Models\Email;
use App\Models\History;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\PinjamLabController;
use App\Http\Controllers\KeranjangController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //dd(Auth::user());
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $total = DB::select("select count(idorder) as jumlah from .order where mahasiswa = '".auth()->user()->nrpnpk."'");
        $totalaktif = DB::select("select count(idorder) as jumlah from .order where status = 0 and mahasiswa = '".auth()->user()->nrpnpk."'");
        $totalpasif = DB::select("select count(idorder) as jumlah from .order where (status = 1 or status = 2) and mahasiswa = '".auth()->user()->nrpnpk."'");
        $update1 = DB::select("Select h.order, h.tanggal, s.nama From .order o inner join history h on o.idorder = h.order inner join status s on s.idstatus = h.status where h.tanggal = (select max(hi.tanggal) from history hi where hi.order = h.order) and o.mahasiswa = '".auth()->user()->nrpnpk."' and o.status = 0 order by h.tanggal desc");
        $pesanan = Order::where('mahasiswa',auth()->user()->nrpnpk)->get();
       
       
        return view('home.home',compact('total','totalaktif','totalpasif','update1','pesanan'));
    }

    public function gantiprofil1()
    {
        if(auth()->user()->jabatan1()->nama != "Mahasiswa")
        {
            $emailku = Email::where('nrpnpk',auth()->user()->nrpnpk)->first();
            return view("home.gprofil",compact('emailku'));
        }
        else{
            return view("home.gprofil");

        }
    }

    public function gantipassword1()
    {
        return view("home.gpass");
    }
 #############################################   
    public function ordersetujuppj($id)
    {
        $order = Order::where('idorder',$id)->where('mahasiswa',auth()->user()->nrpnpk)->get();
        if(count($order) == 0)
        {
            return redirect(url('/home'))->with("status",4);
        }
        else{
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
            $pemesan = auth()->user();
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
                if(!isset($keranjang[$pb->idlab]))
                {
                    $help['id'] = $pb->idlab;
                    $help['nama'] = $pb->namaLab;
                    $help['lokasi'] = $pb->lokasi;
                    $help['gambar'] = PinjamLabController::gambar($pb->idlab);
                    $help['pinjam'] = array($pinjam);
                    $help['fakultas'] = $pb->fakultas;
                    $help['tipe'] = "lab";
                   $keranjang[$pb->idlab] = $help;
                }
                else
                {
                    array_push($keranjang[$pb->idlab]['pinjam'],$pinjam);
                }
            }
            return view('order.setujupj',compact('pemesan','dosenpj','keranjang','orderku'));
        }
    }
    public function finalsetujupj(Request $request)
    {
        $id = $request->orderid;
        $helper = 0;
        $orderku = Order::where('idorder',$id)->get();
        if($request->setujub != null){
            foreach($request->setujub as $cb)
            {
                $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$cb."'");
                foreach($pesanankubarang as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin != "" || $pb->skalab == 2 )
                    { $helper++; }
                }
            }
        }
        if($request->setujul != null) {
            foreach($request->setujul as $cl)
            {
                $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$cl."'");
                foreach($pesanankulab as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin != "" || $pb->skalab == 2 )
                    { $helper++; }
                }
            }
        }

        if($helper >= 1)
        {
            return redirect('/order/ppj/'.$id)->with('status', '1');
        }
        else{
            DB::statement("update .order set noteDosen = '".$request->pesan."' where idorder = '".$id."'");
            if($request->setujub != null){
                foreach($request->setujub as $k=>$cb)
                {
                    if($cb == 1)
                    {
                        DB::statement("update pinjam set sdosen = 1 , statusDosen = '".auth()->user()->nrpnpk."' where idp = '".$k."'");
                    }
                    else if($cb == 2)
                    {
                        DB::statement("update pinjam set sdosen = 2, statusDosen = '".auth()->user()->nrpnpk."', keterangan = 'Item Tidak Mendapat Persetujuan Penanggungjawab' where idp = '".$k."'");
                    }
                }
            }
            if($request->setujul != null) {
                foreach($request->setujul as $k=>$cl)
                {
                    if($cb == 1)
                    {
                        DB::statement("update pinjamlab set sdosen = 1 , statusDosen = '".auth()->user()->nrpnpk."' where idpl = '".$k."'");
                    }
                    else if($cb == 2)
                    {
                        DB::statement("update pinjamlab set sdosen = 2, keterangan = 'Item Tidak Mendapat Persetujuan Penanggungjawab' , statusDosen = '".auth()->user()->nrpnpk."' where idpl = '".$k."'");
                    }
                }
            }

            $riwayat = new History;
            $riwayat->status = 2;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->pic =auth()->user()->nrpnpk;
            $riwayat->order = $id;
            $riwayat->save();
            $this->matikan($id,auth()->user()->nrpnpk);
            KeranjangController::kirimemail($id,'Item Pada Pesanan Anda Telah Mendapat Respon Dari Penanggungjawab','Item Pada Pesanan Anda Telah Mendapat Respon Dari Penanggungjawab','Pesanan Yang Berkaitan Dengan Anda Mendapatkan Respon Dari Penanggungjawab','Pesanan Yang Berkaitan Dengan Anda Berhasil Dibatalkan Mendapatkan Respon Dari Penanggungjawab','setuju');
            
            return redirect('/order/detail/'.$id)->with('status', '4');
        }
    }
    public function prosesordersetujuppj(Request $request)
    {
        $id = $request->orderid;
        $keranjang = array();
      
        if(isset($request->agreeall))
        {   
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
            $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
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
                    $pinjam['setuju'] = "1";
                    
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
                    $pinjam['setuju'] = "1";
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
        else{
            $orderku = Order::where('idorder',$id)->get();
            if($request->setujub != null){
                foreach($request->setujub as $k=>$cb)
                {
                    $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$k."'");
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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 || $cb == 0)
                            {}
                            else
                            { $keranjang[$pb->idbarangdetail] = $help; }
                            
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 || $cb == 0)
                            {}
                            else
                            { array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam); }
                        }
                    }
                }
            }
            if($request->setujul != null) {
                foreach($request->setujul as $k=>$cl)
                {
                    $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$k."'");
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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 || $cl == 0)
                            {}
                            else
                            { $keranjang[$pb->idlab] = $help1; }
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 || $cl == 0)
                            {}
                            else
                            { array_push($keranjang[$pb->idlab]['pinjam'],$pinjam); }
                        }
                    }
                }
            }
        }
        //dd($keranjang);
        if(count($keranjang) == 0)
        {
            return redirect('/order/ppj/'.$id)->with('status', '2');
        }
        else{
            $pesan = $request->pesan;
            return view("order.konfirmasisetujupj",compact('orderku','keranjang','pesan'));
        }
    }
##############################################
    public function ordersetujul($id)
    {
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');
        $order = Order::where('idorder',$id)->where('mahasiswa',auth()->user()->nrpnpk)->get();
        if(count($order) == 0)
        {
            return redirect(url('/home'))->with("status",4);
        }
        else{
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.idlab,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
            $pemesan = auth()->user();
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
            return view('order.setujul',compact('pemesan','dosenpj','keranjang','orderku'));
        }
    }
    public function finalsetujul(Request $request)
    {
        $id = $request->orderid;
        $helper = 0;
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');
        $orderku = Order::where('idorder',$id)->get();
        if($request->setujub != null){
            foreach($request->setujub as $cb)
            {
                $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi,l.idlab, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$cb."'");
                foreach($pesanankubarang as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin != "" || $pb->skalab == 2 )
                    { 
                        if($pb->idlab == $la->lab)
                        { $helper++; }
                    }
                }
            }
        }
        if($request->setujul != null) {
            foreach($request->setujul as $cl)
            {
                $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$cl."'");
                foreach($pesanankulab as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin != "" || $pb->skalab == 2 )
                    {
                        if($pb->idlab == $la->lab)
                        { $helper++; }
                    }    
                }
            }
        }

        if($helper >= 1)
        {
            return redirect('/order/pl/'.$id)->with('status', '1');
        }
        else{
            DB::statement("update .order set noteKalab = '".$request->pesan."' where idorder = '".$id."'");
            if($request->setujub != null){
                foreach($request->setujub as $k=>$cb)
                {
                    if($cb == 1)
                    {
                        DB::statement("update pinjam set skalab = 1 , statusKalab = '".auth()->user()->nrpnpk."' where idp = '".$k."'");
                    }
                    else if($cb == 2)
                    {
                        DB::statement("update pinjam set skalab = 2, statusKalab = '".auth()->user()->nrpnpk."', keterangan = 'Item Tidak Mendapat Persetujuan Kalab / Laboran' where idp = '".$k."'");
                    }
                }
            }
            if($request->setujul != null) {
                foreach($request->setujul as $k=>$cl)
                {
                    if($cb == 1)
                    {
                        DB::statement("update pinjamlab set skalab = 1 , statusKalab = '".auth()->user()->nrpnpk."' where idpl = '".$k."'");
                    }
                    else if($cb == 2)
                    {
                        DB::statement("update pinjamlab set skalab = 2, keterangan = 'Item Tidak Mendapat Persetujuan  Kalab / Laboran' , statusKalab = '".auth()->user()->nrpnpk."' where idpl = '".$k."'");
                    }
                }
            }

            $riwayat = new History;
            $riwayat->status = 5;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->pic =auth()->user()->nrpnpk;
            $riwayat->order = $id;
            $riwayat->save();
            $this->matikan($id,auth()->user()->nrpnpk);
            KeranjangController::kirimemail($id,'Item Pada Pesanan Anda Telah Mendapat Respon Dari Kalab / Laboran','Item Pada Pesanan Anda Telah Mendapat Respon Dari Kalab / Laboran','Pesanan Yang Berkaitan Dengan Anda Mendapatkan Respon Dari Kalab / Laboran','Pesanan Yang Berkaitan Dengan Anda Berhasil Dibatalkan Mendapatkan Respon Dari Kalab / Laboran','setuju');
            return redirect('/order/detail/'.$id)->with('status', '4');
        }
    }
    public function prosesordersetujul(Request $request)
    {
        $id = $request->orderid;
        $keranjang = array();
        $laboran = DB::select('select * from laboran where user = "'.auth()->user()->nrpnpk.'"');

        if(isset($request->agreeall))
        {   
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi,l.idlab, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
            $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
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
                    $pinjam['setuju'] = "1";
                    
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
                    { 
                        foreach($laboran as $la)
                        {
                            if($pb->idlab == $la->lab)
                            { $keranjang[$pb->idbarangdetail] = $help; }
                        }
                    }
                }
                else
                {
                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 )
                    {}
                    else
                    { 
                        foreach($laboran as $la)
                        {
                            if($pb->idlab == $la->lab)
                            { array_push($keranjang[$pb->idbarangdetail]['pinjam'],$pinjam); }
                        }
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
                    $pinjam['setuju'] = "1";
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
                    { 
                        foreach($laboran as $la)
                        {
                            if($pb->idlab == $la->lab)
                            { $keranjang[$pb->idlab] = $help;  }
                        }
                    }
                }
                else
                {
                    if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 )
                    {}
                    else
                    { 
                        foreach($laboran as $la)
                        {
                            if($pb->idlab == $la->lab)
                            {array_push($keranjang[$pb->idlab]['pinjam'],$pinjam);  }
                        }
                    }
                }
            }
        }
        else{
            $orderku = Order::where('idorder',$id)->get();
            if($request->setujub != null){
                foreach($request->setujub as $k=>$cb)
                {
                    $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$k."'");
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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 || $cb == 0)
                            {}
                            else
                            { 
                                foreach($laboran as $la)
                                {
                                    if($pb->idlab == $la->lab)
                                    {$keranjang[$pb->idbarangdetail] = $help;  }
                                }
                            }        
                        }
                        else
                        {
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 || $cb == 0)
                            {}
                            else
                            { 
                                foreach($laboran as $la)
                                {
                                    if($pb->idlab == $la->lab)
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
                    $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$k."'");
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

                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 || $cl == 0)
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
                            if($pinjam['sdosen'] == 2 || $pinjam['status'] == 2 || $pinjam['checkout'] != "" || $pinjam['checkin'] != "" || $pinjam['skalab'] == 2 || $cl == 0)
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
        }
        //dd($keranjang);
        if(count($keranjang) == 0)
        {
            return redirect('/order/pl/'.$id)->with('status', '2');
        }
        else{
            $pesan = $request->pesan;
            return view("order.konfirmasisetujul",compact('orderku','keranjang','pesan'));
        }
    }
#############################################
    public function orderbatal($id)
    {
        $order = Order::where('idorder',$id)->where('mahasiswa',auth()->user()->nrpnpk)->get();
        if(count($order) == 0)
        {
            return redirect(url('/home'))->with("status",4);
        }
        else{
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
            $pesanankulab = DB::select("select p.status, p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
            $pemesan = auth()->user();
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
                if(!isset($keranjang[$pb->idlab]))
                {
                    $help['id'] = $pb->idlab;
                    $help['nama'] = $pb->namaLab;
                    $help['lokasi'] = $pb->lokasi;
                    $help['gambar'] = PinjamLabController::gambar($pb->idlab);
                    $help['pinjam'] = array($pinjam);
                    $help['fakultas'] = $pb->fakultas;
                    $help['tipe'] = "lab";
                   $keranjang[$pb->idlab] = $help;
                }
                else
                {
                    array_push($keranjang[$pb->idlab]['pinjam'],$pinjam);
                }
            }
            return view('order.batalkan',compact('pemesan','dosenpj','keranjang','orderku'));
        }
    }

    public function prosesorderbatal(Request $request)
    {
        $id = $request->orderid;
        $keranjang = array();
      
        if(isset($request->cancelall))
        {   
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
            $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
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
            if($request->cancelb != null){
                foreach($request->cancelb as $cb)
                {
                    $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$cb."'");
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
            if($request->cancell != null) {
                foreach($request->cancell as $cl)
                {
                    $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$cl."'");
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
            return redirect('/order/batalkan/'.$id)->with('status', '2');
        }
        else{
            return view("order.konfirmasibatal",compact('orderku','keranjang'));
        }
        
    }
    public function matikan($orderid,$pic)
    {
        $helper = 0;
        $orderku = Order::where('idorder',$orderid)->get();// dd($orderku);
        $pesanankubarang = DB::select("select p.sdosen, p.skalab, p.idp, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$orderid."' order by b.nama");
        $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, p.idpl, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$orderid."' order by l.namaLab");
        foreach($pesanankubarang as $pb)
        {
            if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout != "" || $pb->skalab == 2 )
            { $helper++; }
        }
        foreach($pesanankulab as $pb)
        {
            if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout != "" || $pb->skalab == 2 )
            { $helper++; }
        }

        if($helper == (count($pesanankubarang)+count($pesanankulab)))
        {
            DB::statement("update .order  set status = 2 where idorder = '".$orderid."'");
            $riwayat = new History;
            $riwayat->status = 4;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->pic =$pic;
            $riwayat->order = $orderid;
            $riwayat->save();
            return 1;
        }
        else { return 0; }
    }

    public function finalbatal(Request $request)
    {
        $id = $request->orderid;
        $helper = 0;
        $orderku = Order::where('idorder',$id)->get();
        if($request->cancelb != null){
            foreach($request->cancelb as $cb)
            {
                $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.idp = '".$cb."'");
                foreach($pesanankubarang as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin != "" || $pb->skalab == 2 )
                    { $helper++; }
                }
            }
        }
        if($request->cancell != null) {
            foreach($request->cancell as $cl)
            {
                $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idpl = '".$cl."'");
                foreach($pesanankulab as $pb)
                {
                    if($pb->sdosen == 2 || $pb->status == 2 || $pb->checkout != "" || $pb->checkin != "" || $pb->skalab == 2 )
                    { $helper++; }
                }
            }
        }

        if($helper >= 1)
        {
            return redirect('/order/batalkan/'.$id)->with('status', '1');
        }
        else{
            if($request->cancelb != null){
                foreach($request->cancelb as $cb)
                {
                    DB::statement("update pinjam set status = 2, keterangan = 'Item Dibatalkan Oleh Pemesan' where idp = '".$cb."'");
                }
            }
            if($request->cancell != null) {
                foreach($request->cancell as $cl)
                {
                    DB::statement("update pinjamlab set status = 2, keterangan = 'Item Dibatalkan Oleh Pemesan' where idpl = '".$cl."'");
                }
            }

            $riwayat = new History;
            $riwayat->status = 3;
            $riwayat->tanggal = date("Y-m-d H:i:s");
            $riwayat->pic =auth()->user()->nrpnpk;
            $riwayat->order = $id;
            $riwayat->save();
            $this->matikan($id,auth()->user()->nrpnpk);
            KeranjangController::kirimemail($id,'Item Pada Pesanan Anda Berhasil Dibatalkan','Item Pada Pesanan Anda Berhasil Dibatalkan','Pesanan Yang Berkaitan Dengan Anda Berhasil Dibatalkan','Pesanan Yang Berkaitan Dengan Anda Berhasil Dibatalkan','batal');
            
            return redirect('/order/detail/'.$id)->with('status', '1');
        }
        
    }

    public function gantiprofil2(Request $request)
    {
        if ( Hash::check($request->pass, auth()->user()->password)) {
            $user = User::where('nrpnpk',auth()->user()->nrpnpk)->first();
            $user->notelp = $request->notelp;
            $user->lineId = $request->line;
            $user->save();
            if(auth()->user()->jabatan1()->nama != "Mahasiswa")
            {
                $emailku = Email::where('nrpnpk',auth()->user()->nrpnpk)->first();
                if($request->cb1 == 1){$emailku->buat = 1;}
                else{$emailku->buat = 0;}
                if($request->cb2 == 1){$emailku->batal = 1;}
                else{$emailku->batal = 0;}
                if($request->cb3 == 1){$emailku->setuju = 1;}
                else{$emailku->setuju = 0;}
                if($request->cb4 == 1){$emailku->ambil = 1;}
                else{$emailku->ambil = 0;}
                if($request->cb5 == 1){$emailku->kembalikan = 1;}
                else{$emailku->kembalikan = 0;}
                $emailku->save();
            }   
            auth()->user()->lineid = $request->line;
            auth()->user()->notelp = $request->notelp;
            return redirect(url('/home'))->with("status",1);
        }
        else{
            return redirect()->back()->with("status",1);
        }
        
    }

    public function gantipassword2(Request $request)
    {
        if($request->pass1 == $request->pass2)
        {
            if ( Hash::check($request->pass3, auth()->user()->password)) {
                $user = User::where('nrpnpk',auth()->user()->nrpnpk)->first();
                $newpass = Hash::make($request->pass2);
                $user->password = $newpass; 
                $user->save();
                auth()->user()->password = $newpass;
                return redirect(url('/home'))->with("status",3);
            }
            else{
                return redirect()->back()->with("status",1);
            }
        }
        else{
            return redirect()->back()->with("status",2);
        }
    }

    public function showorder(Request $request)
    {
        $order = Order::where('idorder',$request->ido)->where('mahasiswa',auth()->user()->nrpnpk)->get();
       
        if(count($order) == 0)
        {
            return("<h3 style='padding: 0px 20px 0px 20px;'>Order Tidak Tersedia</h3>");
        }
        else{
            $pesanankubarang = DB::select("select k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$request->ido."' order by b.nama");
            $pesanankulab = DB::select("select l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$request->ido."' order by l.namaLab");
            $out = "<table>";
            foreach ($pesanankubarang as $pb)
            { 
                $out.="<tr><td>".$pb->nama."</td><td>".$pb->tanggal." ".$pb->mulai." - ".$pb->selesai."</td></tr>";
            }
            foreach ($pesanankulab as $pb)
            { 
                $out.="<tr><td>".$pb->namaLab."</td><td>".$pb->tanggal." ".$pb->mulai." - ".$pb->selesai."</td></tr>";
            }
            $out.= "</table>";
            return $out;
        }
    }

    public function orderdetail($id)
    {
        $order = Order::where('idorder',$id)->where('mahasiswa',auth()->user()->nrpnpk)->get();
        $order1 = Order::where('idorder',$id)->where('dosen',auth()->user()->nrpnpk)->get();
        
        if(count($order)+ count($order1) + KeranjangController::laborannya($id,auth()->user()->nrpnpk) == 0)
        {
            return redirect(url('/home'))->with("status",4);
        }
        else{
            $orderku = Order::where('idorder',$id)->get();// dd($orderku);
            $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
            $pesanankubarang = DB::select("select p.sdosen, p.skalab,k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk,l.lokasi, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
            $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
            $pemesan = auth()->user();
            $pesan = "Terima Kasih Pesanan Anda Telah Kami Terima";
            $status = DB::select('select * from history h inner join status s on h.status = s.idstatus where h.order = "'.$id.'"');
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
                if(!isset($keranjang[$pb->idlab]))
                {
                    $help['id'] = $pb->idlab;
                    $help['nama'] = $pb->namaLab;
                    $help['lokasi'] = $pb->lokasi;
                    $help['gambar'] = PinjamLabController::gambar($pb->idlab);
                    $help['pinjam'] = array($pinjam);
                    $help['fakultas'] = $pb->fakultas;
                    $help['tipe'] = "lab";
                   $keranjang[$pb->idlab] = $help;
                }
                else
                {
                    array_push($keranjang[$pb->idlab]['pinjam'],$pinjam);
                }
            }
            //dd($keranjang);
            return view('order.detail',compact('pemesan','dosenpj','keranjang','orderku','pesan','status'));
        }
    }
}
