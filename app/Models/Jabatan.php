<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    public $primaryKey = 'idjabatan';
    public $timestamps = false;
    public function users()
    {
        return $this->hasMany('App\User','idjabatan','idUser');
    }
}
