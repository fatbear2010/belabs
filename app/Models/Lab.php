<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;
    public function barangDetails()
    {
        return $this->hasMany('App\BarangDetail','idlab','idbarangDetail');
    }
}
