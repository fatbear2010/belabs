<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailOrder extends Mailable 
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pemesan , $dosen , $pesananbrg, $pesananlab, $order, $subjek, $pesan, $status,$ambil,$balik)
    {
        $this->pemesan = $pemesan;
        $this->dosen = $dosen;
        $this->pesananbrg = $pesananbrg;
        $this->pesananlab = $pesananlab;
        $this->order = $order;
        $this->subjek = $subjek;
        $this->pesan = $pesan;
        $this->status = $status;
        $this->ambil = $ambil;
        $this->balik = $balik;
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
        $orderku = $this->order;
        $pesan = $this->pesan;
        $status = $this->status;
        $ambil = $this->ambil;
        $balik = $this->balik;
        return $this->from(env('MAIL_USERNAME','BeLABS'))->subject($this->subjek)->view('mail.m_orderconfirmation',compact('pemesan','dosenpj','pesanankubarang','pesanankulab','orderku','pesan','status','ambil','balik')); 
       // return $this->from(env('MAIL_USERNAME','BeLabs'))->subject('Verifikasi Akun BeLabs')->view('mail.m_verifikasi', compact('')); 
    }
}
