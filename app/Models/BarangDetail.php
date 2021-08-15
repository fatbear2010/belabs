<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangDetail extends Model
{
    protected $table = 'barangdetail';
    public $timestamps = false;
    public function barangs()
    {
        return $this->belongsTo('App\Barang','idbarang');
    }
    public function gambars()
    {
        return $this->hasMany('App\GambarBarang','idbarangDetail','idgambar');
    }
    public function perbaikans()
    {
        return $this->hasMany('App\Perbaikan','idbarangDetail','idperbaikan');
    }
    public function labs()
    {
        return $this->belongsTo('App\Lab','idlab');
    }
    //kurang  ke tabel pinjam 
}
