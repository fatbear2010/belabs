<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jabatan;
use App\Mail\email;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    protected function aktivasi1(Request $request)
    {
        $user = User::where('nrpnpk',$request->nrpnpk)->first();
        if($user)
        {
            if($user->status == '1')
            {
                $error = 'Akun Anda Telah Aktif, Silahkan Melakukan Login';
                return view('auth.register',compact('error'));
            }
            else if($user->status == '2')
            {
                $nama = $user->nama;
                $email = $user->email;
                $nrpnpk = $user->nrpnpk;
                $vcode = Hash::make($nrpnpk);
                $user->vcode = $vcode;
                $user->save();
                Mail::to('21stefsk@gmail.com')->send(new email($nama,'https://localhost/kp/belabs2/public/vcodes/'.$vcode));
                return view('auth.vcode',compact('nama','email','nrpnpk')); 
            }
            else if($user->status == '3')
            {
                $error = 'Akun Anda Terblokir, Silahkan Hubungi Admin';
                return view('auth.register',compact('error'));
            }
        }
        else{
            $error = 'NRP atau NPK Tidak Terdaftar Silah Periksa Kembali Atau Hubungi Admin';
            return view('auth.register',compact('error'));
        }
    }

    protected function aktivasi2($id)
    {
        $user = User::where('nrpnpk',$id)->first();
        if($user)
        {
            if($user->status == '1')
            {
                $error = 'Akun Anda Telah Aktif, Silahkan Melakukan Login';
                return view('auth.register',compact('error'));
            }
            else if($user->status == '2')
            {
                $nama = $user->nama;
                $email = $user->email;
                $nrpnpk = $user->nrpnpk;
                $vcode = Hash::make($nrpnpk);
                $user->vcode = $vcode;
                $user->save();
                Mail::to('21stefsk@gmail.com')->send(new email('nama','https://localhost/kp/belabs2/public/vcodes/'.$vcode));
                return view('auth.vcode',compact('nama','email','nrpnpk')); 
            }
            else if($user->status == '3')
            {
                $error = 'Akun Anda Terblokir, Silahkan Hubungi Admin';
                return view('auth.register',compact('error'));
            }
        }
        else{
            $error = 'NRP atau NPK Tidak Terdaftar Silah Periksa Kembali Atau Hubungi Admin';
            return view('auth.register',compact('error'));
        }
    }

    protected function aktivasi3($vcode)
    {
        $user = User::where('vcode',$vcode)->first();
        if($user)
        {
            $nama = $user->nama;
            $nrpnpk = $user->nrpnpk;
            $jabatan = Jabatan::where('idjabatan',$user->jabatan)->first();

            //dd($jabatan);
            return view('auth.registration',compact('nama','nrpnpk','vcode','jabatan')); 
        }
        else{
            $error = 'Link Verifikasi Salah Atau Sudah Tidak Berlaku';
            return view('auth.registration',compact('error'));
        }
    }
}
