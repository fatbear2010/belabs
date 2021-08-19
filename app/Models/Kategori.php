<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // use HasFactory;
    protected $table = 'kategori';
    public $primaryKey = 'idkategori';
    public $timestamps = false;

    public function barangs()
    {
        return $this->hasMany('App\Barang','idkategori','idbarang');
        //return $this->hasMany('App\tabelyangdituju','idtabelini','idtujuan');
    }
}