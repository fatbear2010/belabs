<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\email;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    protected function sendVerificarionMail(){
        
        if (Hash::check('halo', Hash::make('halo'))) {
            dd(Hash::make('halo'));
        }
        // Mail::to('21stefsk@gmail.com')->send(new email());
    }
}
