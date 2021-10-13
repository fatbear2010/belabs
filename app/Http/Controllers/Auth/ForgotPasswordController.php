<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jabatan;
use App\Mail\emaillp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected function sendResetLinkEmail(Request $request)
    {
        $user = User::where('nrpnpk',$request->nrpnpk)->first();
        if($user)
        {
            if($user->status == '1')
            {
                $nama = $user->nama;
                $email = $user->email;
                $nrpnpk = $user->nrpnpk;
                $vcode = substr(Hash::make($nrpnpk), 0, 10);
                $user->vcode = $vcode;
                $user->save();
                $sukses = 1;
                Mail::to($user->email)->send(new emaillp($nama,'https://localhost/kp/belabs2/public/resetpass/'.$vcode));
                return view('auth.passwords.email',compact('nama','email','nrpnpk','sukses')); 
               
            }
            else if($user->status == '2')
            {
                $error = 'Akun Anda Belum Aktif, Silahkan Melakukan Proses Aktivasi';
                return view('auth.passwords.email',compact('error'));
            }
            else if($user->status == '3')
            {
                $error = 'Akun Anda Terblokir, Silahkan Hubungi Admin';
                return view('auth.passwords.email',compact('error'));
            }
        }
        else{
            $error = 'NRP atau NPK Tidak Terdaftar Silah Periksa Kembali Atau Hubungi Admin';
            return view('auth.passwords.email',compact('error'));
        }
    }

    protected function reset1($id)
    {
        $user = User::where('nrpnpk',$id)->first();
        if($user)
        {
            if($user->status == '1')
            {
                $nama = $user->nama;
                $email = $user->email;
                $nrpnpk = $user->nrpnpk;
                $vcode = substr(Hash::make($nrpnpk), 0, 10);
                $user->vcode = $vcode;
                $user->save();
                $sukses = 1;
                Mail::to($user->email)->send(new emaillp($nama,'https://localhost/kp/belabs2/public/resetpass/'.$vcode));
                return view('auth.passwords.email',compact('nama','email','nrpnpk','sukses')); 
               
            }
            else if($user->status == '2')
            {
                $error = 'Akun Anda Belum Aktif, Silahkan Melakukan Proses Aktivasi';
                return view('auth.passwords.email',compact('error'));
            }
            else if($user->status == '3')
            {
                $error = 'Akun Anda Terblokir, Silahkan Hubungi Admin';
                return view('auth.passwords.email',compact('error'));
            }
        }
        else{
            $error = 'NRP atau NPK Tidak Terdaftar Silah Periksa Kembali Atau Hubungi Admin';
            return view('auth.passwords.email',compact('error'));
        }
    }

    protected function reset2($vcode)
    {
        $user = User::where('vcode',$vcode)->first();
        if($user)
        {
            $nama = $user->nama;
            $nrpnpk = $user->nrpnpk;
            $jabatan = Jabatan::where('idjabatan',$user->jabatan)->first();

           // dd($jabatan);
            return view('auth.passwords.reset',compact('nama','nrpnpk','vcode','jabatan')); 
        }
        else{
            $error = 'Link Verifikasi Salah Atau Sudah Tidak Berlaku';
            return view('auth.passwords.reset',compact('error'));
        }
    }


    protected function reset3(Request $request)
    {   
        $user = User::where('vcode',$request->vcode)->first();
        if($user)
        {
            if($request->pass1 == $request->pass2)
            {
                $user->password = Hash::make($request->pass1);
                $user->vcode = Hash::make($user->nrpnpk);
                $user->save();
                $nama = $user->nama;
                $nrpnpk = $user->nrpnpk;
                $jabatan = Jabatan::where('idjabatan',$user->jabatan)->first();
                $done = "Selamat Password Anda Berhasil Di Reset, Silahkan Lakukan Login";
    
                return view('auth.passwords.reset',compact('nama','done','jabatan')); 
            }
            else
            {
                $vcode = $request->vcode;
                $nama = $user->nama;
                $nrpnpk = $user->nrpnpk;
                $jabatan = Jabatan::where('idjabatan',$user->jabatan)->first();
                $error1 = 'Password Tidak Sama';
                return view('auth.passwords.reset',compact('error1','nama','jabatan','vcode'));
            }
           
        }
        else{
            $error = 'Ada Yang Salah, Silahkan Ulangi Proses Reset Password';
            return view('auth.passwords.reset',compact('error'));
        }

    }

}
