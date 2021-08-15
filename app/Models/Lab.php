<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $table = 'lab';
    public $primaryKey = 'idlab';
    public $timestamps = false;
    public function barangDetails()
    {
        return $this->hasMany('App\BarangDetail','idlab','idbarangDetail');
    }
}
