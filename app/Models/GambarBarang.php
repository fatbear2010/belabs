<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarBarang extends Model
{
    protected $table = 'gambar';
    public $primaryKey = 'idgambar';
    public $timestamps = false;
    public function barangDetails()
    {
        return $this->belongsTo('App\BarangDetail','idbarangDetail');
    }
}
