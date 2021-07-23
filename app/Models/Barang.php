<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //use HasFactory;
    protected $table = 'barang';
    public $primaryKey = 'idbarang';
    public $keyType = 'string';
    public $timestamps = false;

    public function kategoris()
    {
        return $this->belongsTo('App\Kategori','idkategori');
    }

    public function barangDetails()
    {
        return $this->hasMany('App\BarangDetail','idbarang','idbarangDetail');
    }
}
