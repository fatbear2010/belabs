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
use App\Models\Lab;
use App\Models\Order;
use App\Models\History;
use App\Models\Email;
use App\Models\Ambilbalik;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\PinjamLabController;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use App\Mail\emailOrder;
use App\Mail\emaila;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public static function jurusan($id)
    {
        $jus = Jurusan::where('idjurusan',$id)->first();
        $fak = Fakultas::where('idfakultas',$jus->fakultas)->first();
        return $jus->namaJurusan ." - ".$fak->namafakultas;
    }

    public static function cariorang($id)
    {
        $orang = User::where('nrpnpk',$id)->first();
        return $id." - ".$orang->nama;
    }

    public static function fakultas($id)
    {
        $fak = Fakultas::where('idfakultas',$id)->first();
        return $fak->namafakultas;
    }

    public static function itemname($id)
    {
        $item = DB::select("select b.nama , p.tanggal, p.mulai, p.selesai from pinjam p inner join barangdetail b on p.barang = b.idbarangDetail where p.idp = '".$id."'");
        return $item[0]->nama." ".$item[0]->tanggal." ".$item[0]->mulai." - ".$item[0]->selesai;
    }

    public static function labname($id)
    {
        $item = DB::select("select b.namalab , p.tanggal, p.mulai, p.selesai from pinjamlab p inner join lab b on p.idlab = b.idlab where p.idpl = '".$id."'");
        return $item[0]->namalab." ".$item[0]->tanggal." ".$item[0]->mulai." - ".$item[0]->selesai;
    }

    public static function labaja($id)
    {
        $la = Lab::where('idlab',$id)->first();
        return $la->namaLab;
    }

    public static function laborannya2($lab , $nrpnpk)
    {
        $laboran = DB::select("select * from laboran where user = '".$nrpnpk."' and lab = '".$lab."'");
       return(count($laboran));
    }

    public static function laborannya($orderid, $nrpnpk)
    {
        $laboran = DB::select("select DISTINCT la.user from laboran la inner join (select DISTINCT bd.lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$orderid."' union select DISTINCT idlab from pinjamLab  where idorder = '".$orderid."') lb on la.lab = lb.lab where la.user = '".$nrpnpk."'");
       // dd("select DISTINCT la.user from laboran la left join (select DISTINCT bd.lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$orderid."' union select DISTINCT idlab from pinjamLab  where idorder = '".$orderid."') lb on la.lab = lb.lab where la.user = '".$nrpnpk."'");
        return(count($laboran));
    }

    public function clean(Request $request)
    {
        session()->put('cart',array());
        if(isset($request->kr))
        {
            session()->put('cart2',array());
        }
        return "";
    }

    public function hapusPinjam(Request $request)
    {
        $id = substr($request->id,5);
        $index = intval(substr($request->id,1,4));
        $status = 0;

        $cart=Session()->get('cart');
        if(count($cart[$id]['pinjam'])<= 1)
        {
            unset($cart[$id]);
            $status = 0;
        }
        else{
            unset($cart[$id]['pinjam'][$index]);
            $status = 1;
        }

        if(count($cart)==0)
        {
            $status = 2;
        }
        
       
        //dd($cart);
        session()->put('cart',$cart);
        if(isset($request->kr))
        {
            session()->put('cart2',$cart);
        }
        return $status;
    }

    public function hapusBarang(Request $request)
    {
        $id = substr($request->id,1);
        $status = 1;

        $cart=Session()->get('cart');
        unset($cart[$id]);
        
        if(count($cart)==0)
        {
            $status = 2;
        }
        session()->put('cart',$cart);
        if(isset($request->kr))
        {
            session()->put('cart2',$cart);
        }
        return $status;
    }

    public function keranjangdetail()
    {
        $lihat= 0;
        $random = random_int(100000, 999999);
        $keranjang =Session()->get('cart');
        session()->put('cart2',$keranjang);
        session()->put('random',$random);
        $dosen = DB::select('select * from users where jabatan != 1 and jabatan != 9');
        //dd($dosen);
        return view('order.checkout',compact('lihat','dosen','random'));
    }

    public function dosen(Request $request)
    {
        $dosen = DB::select('select * from users where nrpnpk = '.$request->dosen);
        //dd($dosen);
        return view('order.dosen',compact('dosen'));
    }

    public function checkout(Request $request)
    {
        $keranjang =Session()->get('cart2');
        $value =0 ;
        
            if($keranjang != null){
                foreach($keranjang as $k)
                {
                    foreach($k['pinjam']as $p)
                    {
                        if($k['tipe'] == "barang")
                        {
                            if(PinjamController::cekAda($k['id'],$p['tgl'],$p['mulai'],$p['selesai'])==1){$value++;}
                        }
                        else if($k['tipe'] == "lab")
                        {
                            if(PinjamLabController::cekAda($k['id'],$p['tgl'],$p['mulai'],$p['selesai'])==1){$value++;}
                        }
                    }
                }
                if($value == 0)
                {
                    $pesan = $request->pesan;
                    $dosenku = DB::select('select * from users where nrpnpk = '.$request->dosen);
                    session()->put('cart3',$keranjang);
                    $random = $request->random;
                    session()->put('pesan',$request->pesan); 
                    session()->put('dosen',$request->dosen);
                    return view('order.checkout2',compact('keranjang','pesan','dosenku','random'));
                }
                else
                {
                    return redirect()->back();
                    //compact('keranjang','pesan','dosenku'));
                }
            }
            else 
            {
                return redirect()->back()->with("status",1);
            }
    }
    public function final(Request $request)
    {
        //dd($request);
        //echo $request->random;
       // echo .Session()->get('random');
        if($request->random == Session()->get('random'))
        {
            //do something here 
            $keranjang =Session()->get('cart3');
            $value =0 ;
            
                if($keranjang != null){
                    foreach($keranjang as $k)
                    {
                        foreach($k['pinjam']as $p)
                        {
                            if($k['tipe'] == "barang")
                            {
                                if(PinjamController::cekAda($k['id'],$p['tgl'],$p['mulai'],$p['selesai'])==1){$value++;}
                            }
                            else if($k['tipe'] == "lab")
                            {
                                if(PinjamLabController::cekAda($k['id'],$p['tgl'],$p['mulai'],$p['selesai'])==1){$value++;}
                            }
                        }
                    }
                    if($value == 0)
                    {
                        
                        $pesan = $request->pesan;
                        $dosenku = $request->dosen;
                        $order = new Order();
                        $id = date("dmY");
                        $nomor = DB::select("select count(idorder) as jumlah FROM .order where idorder like'".$id."%'");
                        $id.= str_pad($nomor[0]->jumlah+1,5,"0",STR_PAD_LEFT);

                        $order->idorder = $id;
                        $order->mahasiswa = auth()->user()->nrpnpk;
                        $order->dosen = $dosenku;
                        $order->status = 0;
                        $order->tanggal = date("Y-m-d H:i:s");
                        $order->notePeminjam = $pesan;
                        $order->save();
                        
                        foreach($keranjang as $k)
                        {
                            foreach($k['pinjam']as $p)
                            {
                                if($k['tipe'] == "barang")
                                {
                                    $dipinjam = new Pinjam();
                                    $dipinjam->tanggal = date("Y-m-d", strtotime($p['tgl']));
                                    $dipinjam->mulai = $p['mulai'];
                                    $dipinjam->selesai = $p['selesai'];
                                    $dipinjam->barang = $k['id'];
                                    $dipinjam->order = $id;
                                    $dipinjam->sdosen = 0;
                                    $dipinjam->skalab = 0;
                                    $dipinjam->status = 0;
                                    $dipinjam->save();
                                }
                                else if($k['tipe'] == "lab")
                                {
                                    $dipinjam = new PinjamLab();
                                    $dipinjam->tanggal = date("Y-m-d", strtotime($p['tgl']));
                                    $dipinjam->mulai = $p['mulai'];
                                    $dipinjam->selesai = $p['selesai'];
                                    $dipinjam->idlab = $k['id'];
                                    $dipinjam->idorder = $id;
                                    $dipinjam->sdosen = 0;
                                    $dipinjam->skalab = 0;
                                    $dipinjam->status = 0;
                                    $dipinjam->save();
                                }
                            }
                        }

                        $riwayat = new History;
                        $riwayat->status = 1;
                        $riwayat->tanggal = date("Y-m-d H:i:s");
                        $riwayat->pic ='020102000';
                        $riwayat->order = $id;
                        $riwayat->save();
                        $dosenpj = DB::select('select * from users where nrpnpk = "'.$request->dosen.'"');
                        $pesanankubarang = DB::select("select p.sdosen, p.skalab,p.checkin1, p.checkout1, l.lokasi, k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
                        $pesanankulab = DB::select("select p.sdosen, p.skalab,p.checkin1, p.checkout1, l.namaLab, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
                        $orderku = Order::where('idorder',$id)->get();
                        $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
                        $ambil = Ambilbalik::where('order',$id)->where('tipe','AMBIL')->get();
                        $balik = Ambilbalik::where('order',$id)->where('tipe','BALIK')->get();
                        $pesan = "Terima Kasih <br> Pesanan Anda Telah Kami Terima";
                        $status = DB::select('select * from history h inner join status s on h.status = s.idstatus where h.order = "'.$id.'"');
                        Mail::to($pemesan[0]->email)->send(new emailOrder($pemesan,$dosenpj,$pesanankubarang,$pesanankulab, $orderku,$id.' BeLABS Order Confirmation', 'Terima Kasih, Pesanan Anda Telah Kami Terima', $status,$ambil,$balik));
                       
                        $emaild = Email::where('nrpnpk',$dosenku)->get();
                        if($emaild[0]->buat == 1)
                        {
                            Mail::to($dosenpj[0]->email)->send(new emailOrder($pemesan,$dosenpj,$pesanankubarang,$pesanankulab, $orderku,$id. ' BeLABS Pesanan Ini Memerlukan Persetujuan Anda', 'Pesanan Ini Memerlukan Persetujuan Anda', $status,$ambil,$balik));
                        }
                        
                        $emaillab = DB::select("select DISTINCT user from laboran la left join (select DISTINCT bd.lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.lab = lb.lab");
                        for ($i=0; $i <count($emaillab) ; $i++) { 
                            $emailaboran = Email::where('nrpnpk',$emaillab[$i]->user)->get();
                            $laboran = DB::select('select * from users where nrpnpk = "'.$emaillab[$i]->user.'"');
                            
                            if($emailaboran[0]->buat == 1)
                            {
                                Mail::to($laboran[0]->email)->send(new emailOrder($pemesan,$dosenpj,$pesanankubarang,$pesanankulab, $orderku,$id.' BeLABS Pesanan Ini Memerlukan Persetujuan Anda', 'Pesanan Ini Memerlukan Persetujuan Anda', $status,$ambil,$balik));
                            }
                        }

                        session()->put('cart3',array());
                        session()->put('cart2',array());
                        session()->put('cart',array());
                        session()->put('pesan',""); 
                        session()->put('dosen',"");
                        //return view('mail.m_orderconfirmation',compact('pemesan','dosenpj','pesanankubarang','pesanankulab','orderku','pesan','status'));
                        return redirect(url('/home'))->with("status",2);
                    }
                    else
                    {
                        return redirect(url('/keranjang/keranjangdetail'))->with("status",2);
                        //compact('keranjang','pesan','dosenku'));
                    }
            }
            else 
            {
                return redirect(url('/keranjang/keranjangdetail'))->with("status",1);
            }
        }
        else 
        {
            return redirect(url('/keranjang/keranjangdetail'))->with("status",1);
        }
    }

    public static function kirimemail($id ,$subjek1, $pesan1,$subjek2, $pesan2, $action)
    {
        $orderku = Order::where('idorder',$id)->get();// dd($orderku);
        $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
        $pesanankubarang = DB::select("select p.sdosen, p.skalab, l.lokasi,p.checkin1, p.checkout1, k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
        $pesanankulab = DB::select("select p.sdosen, p.skalab,l.namaLab,p.checkin1, p.checkout1, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
        $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
        $ambil = Ambilbalik::where('order',$id)->where('tipe','AMBIL')->get();
        $balik = Ambilbalik::where('order',$id)->where('tipe','BALIK')->get();
        $pesan = "Terima Kasih Pesanan Anda Telah Kami Terima";
        $status = DB::select('select * from history h inner join status s on h.status = s.idstatus where h.order = "'.$id.'" order by h.tanggal');
        $emaillab = DB::select("select DISTINCT user from laboran la left join (select DISTINCT bd.lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.lab = lb.lab");
        for ($i=0; $i <count($emaillab) ; $i++) { 
            $emailaboran = Email::where('nrpnpk',$emaillab[$i]->user)->get();
            //dd($emailaboran);
            if($emailaboran[0]->$action == 1)
            {
                $emaillab2 = user::where('nrpnpk',$emailaboran[0]->nrpnpk)->get();
                Mail::to($emaillab2[0]->email)->send(new emailOrder($pemesan,$dosenpj,$pesanankubarang,$pesanankulab, $orderku,$id.' BeLABS '.$subjek2, $pesan2, $status,$ambil,$balik));
            }
        }

        Mail::to($pemesan[0]->email)->send(new emailOrder($pemesan,$dosenpj,$pesanankubarang,$pesanankulab, $orderku,$id.' BeLABS '.$subjek1, $pesan1, $status,$ambil,$balik));
                     
        $emaild = Email::where('nrpnpk',$orderku[0]->dosen)->get();
        if($emaild[0]->$action == 1)
        {
            Mail::to($dosenpj[0]->email)->send(new emailOrder($pemesan,$dosenpj,$pesanankubarang,$pesanankulab, $orderku,$id.' BeLABS '.$subjek2, $pesan2, $status,$ambil,$balik));
        }
       
    }

    public static function kirimemaila($id)
    {
        $orderku = Order::where('idorder',substr($id, 0, 13))->get();// dd($orderku);
        $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
        $pesanankubarang = DB::select("select p.sdosen, p.skalab, l.lokasi,p.checkin1, p.checkout1, k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.ambil = '".$id."' order by b.nama");
        $pesanankulab = DB::select("select p.sdosen, p.skalab,l.namaLab,p.checkin1, p.checkout1, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.ambil = '".$id."' order by l.namaLab");
        $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
        $ambil = Ambilbalik::where('idambilbalik',$id)->where('tipe','AMBIL')->get();
        $kalab =  DB::select('select * from users where nrpnpk = "'.$ambil[0]->PIC.'"');
        $pesan = "Pengambilan Item / Kehadiran Masuk Telah Di Proses Oleh Kalab / Laboran";
        $pesan2 = "Pengambilan Item / Kehadiran Masuk Telah Pesanan Yang Berkaitan dengan Anda Di Proses Oleh Kalab / Laboran";
        $emaillab = DB::select("select DISTINCT user from laboran la left join (select DISTINCT bd.lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.lab = lb.lab");
        
        for ($i=0; $i <count($emaillab) ; $i++) { 
            $emailaboran = Email::where('nrpnpk',$emaillab[$i]->user)->get();
            //dd($emailaboran);
            if($emailaboran[0]->ambil == 1)
            {
                $emaillab2 = user::where('nrpnpk',$emailaboran[0]->nrpnpk)->get();
                Mail::to($emaillab2[0]->email)->send(new emaila($pemesan,$dosenpj,$pesanankubarang,$pesanankulab,$ambil,$orderku, substr($id, 0, 13).' BeLABS '.$pesan2, $pesan2, $kalab));
            }
        }
        Mail::to($pemesan[0]->email)->send(new emaila($pemesan,$dosenpj,$pesanankubarang,$pesanankulab,$ambil,$orderku, substr($id, 0, 13).' BeLABS '.$pesan, $pesan, $kalab));
       
                     
        $emaild = Email::where('nrpnpk',$orderku[0]->dosen)->get();
        if($emaild[0]->ambil == 1)
        {
            Mail::to($dosenpj[0]->email)->send(new emaila($pemesan,$dosenpj,$pesanankubarang,$pesanankulab,$ambil,$orderku, substr($id, 0, 13).' BeLABS '.$pesan2, $pesan2, $kalab));
        }
        //return view('mail.m_ambil',compact('pemesan','dosenpj','pesanankubarang','pesanankulab','ambil','orderku','pesan','kalab'));
    }

    public static function kirimemailb($id)
    {
        $orderku = Order::where('idorder',substr($id, 0, 13))->get();// dd($orderku);
        $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
        $pesanankubarang = DB::select("select p.sdosen, p.skalab, l.lokasi,p.checkin1, p.checkout1, k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.ambil = '".$id."' order by b.nama");
        $pesanankulab = DB::select("select p.sdosen, p.skalab,l.namaLab,p.checkin1, p.checkout1, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.ambil = '".$id."' order by l.namaLab");
        $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
        $ambil = Ambilbalik::where('idambilbalik',$id)->where('tipe','BALIK')->get();
        $kalab =  DB::select('select * from users where nrpnpk = "'.$ambil[0]->PIC.'"');
        $pesan = "Pemesan Telah Mengajukan Pengembalian Barang / Kehadiran Keluar";
        $pesan2 = "Pemesan Pesanan Yang Berkaitan Dengan Anda Telah Mengajukan Pengembalian Barang / Kehadiran Keluar";
        $emaillab = DB::select("select DISTINCT user from laboran la left join (select DISTINCT bd.lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.lab = lb.lab");
        
        for ($i=0; $i <count($emaillab) ; $i++) { 
            $emailaboran = Email::where('nrpnpk',$emaillab[$i]->user)->get();
            //dd($emailaboran);
            if($emailaboran[0]->kembalikan == 1)
            {
                $emaillab2 = user::where('nrpnpk',$emailaboran[0]->nrpnpk)->get();
                //dd($emaillab2);
                Mail::to($emaillab2[0]->email)->send(new emaila($pemesan,$dosenpj,$pesanankubarang,$pesanankulab,$ambil,$orderku, substr($id, 0, 13).' BeLABS '.$pesan2, $pesan2, $kalab));
            }
        }
        Mail::to($pemesan[0]->email)->send(new emaila($pemesan,$dosenpj,$pesanankubarang,$pesanankulab,$ambil,$orderku, substr($id, 0, 13).' BeLABS '.$pesan, $pesan, $kalab));
       
                     
        $emaild = Email::where('nrpnpk',$orderku[0]->dosen)->get();
        if($emaild[0]->kembalikan == 1)
        {
            Mail::to($dosenpj[0]->email)->send(new emaila($pemesan,$dosenpj,$pesanankubarang,$pesanankulab,$ambil,$orderku, substr($id, 0, 13).' BeLABS '.$pesan2, $pesan2, $kalab));
        }
    }

    public function test()
    {
        $id = "2910202100001";
        $orderku = Order::where('idorder',$id)->get();//dd($orderku);
        $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
        $pesanankubarang = DB::select("select p.sdosen, p.skalab, l.lokasi,p.checkin1, p.checkout1, k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
        $pesanankulab = DB::select("select p.sdosen, p.skalab,l.namaLab,p.checkin1, p.checkout1, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
        $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
        $ambil = Ambilbalik::where('order',$id)->where('tipe','AMBIL')->get();
        $balik = Ambilbalik::where('order',$id)->where('tipe','BALIK')->get();
        $pesan = "Terima Kasih Pesanan Anda Telah Kami Terima";
        $status = DB::select('select * from history h inner join status s on h.status = s.idstatus where h.order = "'.$id.'" order by h.tanggal');
        $emaillab = DB::select("select DISTINCT user from laboran la left join (select DISTINCT bd.lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.lab = lb.lab");
       
        Mail::to('21stefsk@gmail.com')->queue(new emailOrder($pemesan,$dosenpj,$pesanankubarang,$pesanankulab, $orderku,$id.' BeLABS '.'', $pesan, $status,$ambil,$balik));
                     
      

        /*$id = "2910202100001001";
        $orderku = Order::where('idorder',substr($id, 0, 13))->get();// dd($orderku);
        $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
        $pesanankubarang = DB::select("select p.sdosen, p.skalab, l.lokasi,p.checkin1, p.checkout1, k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.ambil = '".$id."' order by b.nama");
        $pesanankulab = DB::select("select p.sdosen, p.skalab,l.namaLab,p.checkin1, p.checkout1, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.ambil = '".$id."' order by l.namaLab");
        $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
        $ambil = Ambilbalik::where('idambilbalik',$id)->where('tipe','AMBIL')->get();
        $kalab =  DB::select('select * from users where nrpnpk = "'.$ambil[0]->PIC.'"');
        $pesan = "Pengambilan Item / Kehadiran Telah Di Proses Oleh Kalab / Laboran";
        $emaillab = DB::select("select DISTINCT user from laboran la left join (select DISTINCT bd.lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.lab = lb.lab");
        Mail::to($dosenpj[0]->email)->send(new emailOrder($pemesan,$dosenpj,$pesanankubarang,$pesanankulab, $orderku,$id.' BeLABS '.$subjek2, $pesan, $status,$ambil,$balik))->queue('email');
        //return view('mail.m_balik',compact('pemesan','dosenpj','pesanankubarang','pesanankulab','ambil','orderku','pesan','kalab'));
            */
        /*$id= "1410202100003";
        $orderku = Order::where('idorder',$id)->get();// dd($orderku);
        $dosenpj = $dosen = DB::select('select * from users where nrpnpk = "'.$orderku[0]->dosen.'"');
        $pesanankubarang = DB::select("select p.sdosen, p.skalab, l.lokasi,p.checkin1, p.checkout1, k.nama as kategori, br.nama as namaBarang, b.idbarangdetail, b.nama, p.idp, b.merk, l.namaLab, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah,p.statusKalab,p.keterangan, p.status FROM pinjam p inner join barangdetail b on p.barang = b.idbarangDetail inner join lab l on b.lab = l.idlab inner join barang br on b.idbarang = br.idbarang inner join kategori k on br.kategori = k.idkategori where p.order = '".$id."' order by b.nama");
        $pesanankulab = DB::select("select p.sdosen, p.skalab,l.namaLab,p.checkin1, p.checkout1, p.idpl,l.lokasi, l.fakultas, p.tanggal, p.mulai , p.selesai, p.checkin, p.checkout,p.statusDosen,p.masalah, p.statusKalab,p.keterangan, p.status FROM pinjamLab p inner join lab l on p.idlab = l.idlab where p.idorder = '".$id."' order by l.namaLab");
        $pemesan = user::where('nrpnpk',$orderku[0]->mahasiswa)->get();
        $pesan = "Terima Kasih Pesanan Anda Telah Kami Terima";
        $status = DB::select('select * from history h inner join status s on h.status = s.idstatus where h.order = "'.$id.'"');
        $ambil = Ambilbalik::where('order',$id)->where('tipe','AMBIL')->get();
        $balik = Ambilbalik::where('order',$id)->where('tipe','BALIK')->get();
        $emaillab = DB::select("select DISTINCT user from laboran la left join (select DISTINCT bd.lab from pinjam p left join barangdetail bd on bd.idbarangDetail = p.barang where p.order = '".$id."' union select DISTINCT idlab from pinjamLab  where idorder = '".$id."') lb on la.lab = lb.lab");
        for ($i=0; $i <count($emaillab) ; $i++) { 
            $emailaboran = Email::where('nrpnpk',$emaillab[$i]->user)->get();
            //dd($emailaboran);
            if($emailaboran[0]->buat == 1)
            {
               
                //Mail::to($dosenpj->email)->send(new emailOrder($pemesan,$dosenpj,$pesanankubarang,$pesanankulab, $orderku, 'BeLABS Pesanan Ini Memerlukan Persetujuan Anda', 'Pesanan Ini Memerlukan Persetujuan Anda', $status));
            }
        }
        
        return view('mail.m_orderconfirmation',compact('pemesan','dosenpj','pesanankubarang','pesanankulab','ambil','balik','orderku','pesan','status'));*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
}
