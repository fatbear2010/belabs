<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BarangDetail;
use App\Models\Lab;
class Rutin extends Model
{
    protected $table = 'rutin';
    public $primaryKey = 'idrutin';
    public $timestamps = false;
    public function barang()
    {
        return $this->belongsTo(BarangDetail::class,'idbarangDetail','barang');
    }
    public function lab()
    {
        return $this->belongsTo(Lab::class,'idlab','idlab');
    }
}
