<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME','BeLabs'))->subject('Verifikasi Akun BeLabs')->view('mail.m_verifikasi'); 
       // return $this->from(env('MAIL_USERNAME','BeLabs'))->subject('Verifikasi Akun BeLabs')->view('mail.m_verifikasi', compact('')); 
    }
}
