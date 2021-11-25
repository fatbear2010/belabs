<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emaila extends Mailable 
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pemesan , $dosen , $pesananbrg, $pesananlab,$ambil, $order, $subjek, $pesan, $kalab)
    {
        $this->pemesan = $pemesan;
        $this->dosen = $dosen;
        $this->pesananbrg = $pesananbrg;
        $this->pesananlab = $pesananlab;
        $this->ambil = $ambil;
        $this->order = $order;
        $this->subjek = $subjek;
        $this->pesan = $pesan;
        $this->kalab = $kalab;
    }

    /**
     * Build the message
     *
     * @return $this
     */
    public function build()
    {
        $pemesan = $this->pemesan;
        $dosenpj = $this->dosen;
        $pesanankubarang = $this->pesananbrg;
        $pesanankulab = $this->pesananlab;
        $ambil = $this->ambil;
        $orderku = $this->order;
        $pesan = $this->pesan;
        $kalab = $this->kalab;
        
        return $this->from(env('MAIL_USERNAME','BeLABS'))->subject($this->subjek)->view('mail.m_ambil',compact('pemesan','dosenpj','pesanankubarang','pesanankulab','ambil','orderku','pesan','kalab')); 
       // return $this->from(env('MAIL_USERNAME','BeLabs'))->subject('Verifikasi Akun BeLabs')->view('mail.m_verifikasi', compact('')); 
    }
}

