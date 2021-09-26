<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BarangDetail;
use App\Models\Lab;
class Block extends Model
{
    protected $table = 'Block';
    public $primaryKey = 'idblock';
    public $timestamps = false;
    public function barang()
    {
        return $this->belongsTo(BarangDetail::class,'idbarangDetail','idbarangDetail');
    }
    public function lab()
    {
        return $this->belongsTo(Lab::class,'idlab','idlab');
    }
}
