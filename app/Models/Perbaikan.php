<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    protected $table = 'perbaikan';
    public $primaryKey = 'idperbaikan';
    public $timestamps = false;
    
    public function barangDetails()
    {
        return $this->belongsTo('App\BarangDetail','idbarangDetail');
    }
}
