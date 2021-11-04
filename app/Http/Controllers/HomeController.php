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
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\PinjamLabController;

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
        $update1 = DB::select("Select h.order, h.tanggal, s.nama From .order o inner join history h on o.idorder = h.order inner join status s on s.idstatus = h.status where h.tanggal = (select max(hi.tanggal) from history hi where hi.order = h.order) and o.mahasiswa = '".auth()->user()->nrpnpk."' order by h.tanggal desc");
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
            $pesanankulab = DB::select("select p.sdosen, p.skalab,l.idlab, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
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
            //dd($keranjang);
            return view('order.batalkan',compact('pemesan','dosenpj','keranjang','orderku'));
        }
    }

    public function prosesorderbatal()
    {
        return view("home.gpass");
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
        if(count($order) == 0)
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
