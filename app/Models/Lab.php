<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fakultas;

class Lab extends Model
{
    protected $table = 'lab';
    public $primaryKey = 'idlab';
    public $timestamps = false;
    public $keyType = 'string';
    public function barangDetails()
    {
        return $this->hasMany('App\BarangDetail','idlab','idbarangDetail');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User','laboran','idlab','id')
        ->withPivot('keterangan');
    }

    public function fakultas()
    {
        return $this->belongsTo(fakultas::class,'fakultas','idfakultas');
    }
    public function fakultas1()
    {
        return Fakultas::find($this->fakultas);
    }
}
