<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GambarBarang;
class BarangDetail extends Model
{
    protected $table = 'barangdetail';
    public $primaryKey = 'idbarangDetail';
    public $keyType = 'string';
    public $timestamps = false;
    public function barangs()
    {
        return $this->belongsTo('App\Barang','idbarang');
    }
    public function gambars()
    {
        return $this->hasMany(GambarBarang::class,'idbarangDetail','barang');
    }
    public function perbaikans()
    {
        return $this->hasMany(Perbaikan::class,'idbarangDetail','barang');
    }
    public function labs()
    {
        return $this->belongsTo('App\Lab','idlab');
    }
    //kurang  ke tabel pinjam 
}
