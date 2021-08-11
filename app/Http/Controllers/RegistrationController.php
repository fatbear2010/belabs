<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegistrationController extends Controller
{
    protected function aktivasi1(Request $request)
    {
        $user = User::where('iduser',$request->nrpnpk)->first();
        if($user)
        {

        }
        else{
            $error = 'NRP atau NPK Tidak Terdaftar Silah Periksa Kembali Atau Hubungi Admin';
            return view('auth.register',compact('error'));
        }
    }
}
