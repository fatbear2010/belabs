<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lab;
use App\Models\Jurusan;
use App\Models\User;
class Fakultas extends Model
{
    //use HasFactory;
    protected $table = 'fakultas';
    public $primaryKey = 'idfakultas';
    public $keyType = 'string';
    public $timestamps = false;

    public function lab()
    {
        return $this->hasMany(Lab::class,'fakultas','idfakultas');
    }

    public function jurusan()
    {
        return $this->hasMany(Jurusan::class,'idfakultas','fakultas');
    }
}
