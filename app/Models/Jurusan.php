<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lab;
use App\Models\Fakultas;
use App\Models\User;
class Jurusan extends Model
{
    //use HasFactory;
    protected $table = 'jurusan';
    public $primaryKey = 'idjurusan';
    public $keyType = 'string';
    public $timestamps = false;

    public function fakultas()
    {
        return $this->belongsTo(Lab::class,'fakultas','idfakultas');
    }

    public function user()
    {
        return $this->hasMany(Jurusan::class,'idjurusan','jurusan');
    }
}
