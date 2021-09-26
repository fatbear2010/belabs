<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;

class Kategori extends Model
{
    // use HasFactory;
    protected $table = 'kategori';
    public $primaryKey = 'idkategori';
    public $timestamps = false;

    public function barangs()
    {
        return $this->hasMany(Barang::class,'idkategori','kategori');
        //return $this->hasMany('App\tabelyangdituju','idtabelini','idtujuan');
        //return $this->hasMany(GambarBarang::class,'idbarangDetail','barang');
    }
}
