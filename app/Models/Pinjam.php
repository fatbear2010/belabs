<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BarangDetail;
use App\Models\Order;
class Pinjam extends Model
{
    protected $table = 'Pinjam';
    public $primaryKey = 'idp';
    public $timestamps = false;
    public function brang()
    {
        return $this->belongsTo(BarangDetail::class,'idbarangDetail','barang');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'idOrder','order');
    }
}
