<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lab;
use App\Models\Order;
class PinjamLab extends Model
{
    protected $table = 'pinjamLab';
    public $primaryKey = 'idpl';
    public $timestamps = false;
    public function lab()
    {
        return $this->belongsTo(Lab::class,'idlab','idlab');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'idOrder','idorder');
    }
}
