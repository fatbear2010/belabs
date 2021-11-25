<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emaillp extends Mailable 
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nama , $url)
    {
        $this->nama = $nama;
        $this->url = $url;
    }

    /**
     * Build the message
     *
     * @return $this
     */
    public function build()
    {
        $nama = $this->nama;
        $url = $this->url;
        return $this->from(env('MAIL_USERNAME','BeLABS'))->subject('Reset Password Akun BeLABS')->view('mail.m_lupapassword',compact('nama','url')); 
       // return $this->from(env('MAIL_USERNAME','BeLabs'))->subject('Verifikasi Akun BeLabs')->view('mail.m_verifikasi', compact('')); 
    }
}
